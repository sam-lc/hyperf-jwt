<?php
/**
 * Class Jwt Description
 * Created by  PhpStorm.
 * Created Time 2020-01-03 16:15
 *
 * PHP version 7.1
 *
 * @category Jwt
 * @package  P:Samlc\HyperfJwt
 * @author   lichao <lichao@xiaozhu.com>
 * @license  https://lanzu.xiaozhu.com Apache2 Licence
 * @link     https://lanzu.xiaozhu.com
 */

declare(strict_types=1);

namespace Samlc\HyperfJwt;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;
use Samlc\HyperfJwt\Contract\JwtInterface;
use Hyperf\Di\Annotation\Inject;
use Samlc\HyperfJwt\Exception\JwtException;

class Jwt implements JwtInterface
{

    protected $signer;
    protected $config;
    protected $validationData;
    /**
     * @Inject
     * @var \Redis
     */
    protected $redis;

    /**
     * Jwt constructor.
     * @param Signer $signer
     * @param JwtConfig $config
     */
    public function __construct(Signer $signer, JwtConfig $config)
    {
        $this->signer = $signer;
        $this->config = $config;
    }

    /**
     * Fun generate 生成token
     * Created Time 2020-01-06 17:36
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param array $claims
     * @param string|null $identifiedBy
     *
     * @return Token
     * @throws JwtException
     */
    public function generate(array $claims = [], string $identifiedBy = null): Token
    {
        if ($this->config->isSso() && $identifiedBy === null) {
            throw new JwtException('SSO must set identifiedBy');
        }

        $builder = new Builder();
        $now     = time();
        $builder = $builder->issuedAt($now)
            ->issuedBy($this->config->getIss())
            ->expiresAt($now + $this->config->getTtl())
            ->canOnlyBeUsedAfter($now)
            ->permittedFor($this->config->getAud());

        foreach ($claims as $claim => $value) {
            $builder = $builder->withClaim($claim, $value);
        }

        if ($this->config->isSso()) {
            $builder = $builder->identifiedBy($identifiedBy);
            $this->redis->set($identifiedBy, $now);
        }

        $token = $builder->getToken($this->signer, new Signer\Key($this->config->getEncryptKey()));
        return $token;
    }

    /**
     * Fun setValidationData 设置验证数据
     * Created Time 2020-01-06 14:37
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param ValidationData $validationData
     *
     * @return Jwt
     */
    public function setValidationData(ValidationData $validationData): JwtInterface
    {
        $this->validationData = $validationData;
        return $this;
    }

    /**
     * Fun verify 验证
     * Created Time 2020-01-03 18:11
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param string $token
     *
     * @return bool
     */
    public function verify(string $token): bool
    {
        $token = $this->getToken($token);
        return $this->verifyToken($token);
    }

    /**
     * Fun verifyToken Description
     * Created Time 2020-01-06 17:05
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param Token $token
     *
     * @return bool
     */
    protected function verifyToken(Token $token): bool
    {
        return $this->validate($token) && $this->verifyDecode($token);
    }

    /**
     * Fun verifyDecode token解密验证
     * Created Time 2020-01-06 14:43
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param Token $token
     *
     * @return bool
     */
    protected function verifyDecode(Token $token): bool
    {
        return $token->verify($this->signer, new Signer\Key($this->config->getDecodeKey()));
    }

    /**
     * Fun validate 数据验证
     * Created Time 2020-01-06 14:40
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param Token $token
     *
     * @return bool
     */
    protected function validate(Token $token): bool
    {
        if ($this->validationData === null) {
            $this->setValidationData(new ValidationData());
        }
        return $this->isValidateToken($token) && $token->validate($this->validationData);
    }

    /**
     * Fun isValidateToken 是否为废弃token
     * Created Time 2020-01-06 17:44
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param Token $token
     *
     * @return bool
     */
    protected function isValidateToken(Token $token): bool
    {
        if ($this->config->isSso()) {
            return intval($this->redis->get($token->getClaim('jti'))) !== intval($token->getClaim('iat'));
        }
        return false;
    }

    /**
     * Fun getToken Description
     * Created Time 2020-01-06 11:33
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param string $token
     *
     * @return Token
     */
    protected function getToken(string $token): Token
    {
        return (new Parser())->parse($token);
    }

    /**
     * Fun refresh 刷新token
     * Created Time 2020-01-06 17:17
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param string $token
     *
     * @return Token
     * @throws \Exception
     */
    public function refresh(string $token): Token
    {
        $token = $this->getToken($token);
        if (!$this->canRefresh($token)) {
            throw new JwtException('this token is validate,cant refresh');
        }
        $claims = $token->getClaims();
        unset($claims['iat']);
        unset($claims['iss']);
        unset($claims['exp']);
        unset($claims['nbf']);
        unset($claims['aud']);

        return $this->generate($claims, $claims['jti']);
    }

    /**
     * Fun canRefresh 是否可以刷新
     * Created Time 2020-01-06 17:07
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param Token $token
     *
     * @return bool
     */
    protected function canRefresh(Token $token): bool
    {
        if ($this->verifyToken($token)) {
            return true;
        } elseif ($token->getClaim('iat') + $this->config->getRefreshTtl() >= time()) {
            return true;
        }

        return false;
    }
}