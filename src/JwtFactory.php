<?php
/**
 * Class JwtFactory Description
 * Created by  PhpStorm.
 * Created Time 2020-01-06 10:01
 *
 * PHP version 7.1
 *
 * @category JwtFactory
 * @package  P:Samlc\HyperfJwt
 * @author   lichao <lichao@xiaozhu.com>
 * @license  https://lanzu.xiaozhu.com Apache2 Licence
 * @link     https://lanzu.xiaozhu.com
 */

namespace Samlc\HyperfJwt;

use Samlc\HyperfJwt\Exception\JwtException;
use Samlc\HyperfJwt\SingerFactory\EcdsaFactory;
use Samlc\HyperfJwt\SingerFactory\HmacFactory;
use Samlc\HyperfJwt\SingerFactory\RasFactory;
use Samlc\HyperfJwt\SingerFactory\SignerFactory;

class JwtFactory
{
    protected $factory = [
        'rsa'   => RasFactory::class,
        'hmac'  => HmacFactory::class,
        'ecdsa' => EcdsaFactory::class,
    ];

    public function __invoke()
    {
        $config = include __DIR__ . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'jwt.php';
        if (key_exists(strtolower($config['sign_type']), $this->factory)) {
            /**
             * @var SignerFactory $singerFactory
             */
            $singerFactory = new $this->factory[$config['sign_type']]();
            if (method_exists($singerFactory, $config['sign_algorithm'])) {
                $signer = call_user_func([$singerFactory, $config['sign_algorithm']]);
            } else {
                throw new JwtException('sign algorithm only support sha256/sha318/sha512');
            }
        } else {
            throw new JwtException("sign_type:{$config['sign_type']} not in [rsa,hmac,ecdsa]");
        }

        $jwtConfig = new JwtConfig($config['ttl'], $config['key']['encrypt'], $config['key']['decode']);
        $jwtConfig->setSso($config['sso']);
        $jwtConfig->setAud($config['aud']);
        $jwtConfig->setIss($config['iss']);
        $jwtConfig->setRefreshTtl($config['refresh_ttl']);

        return new Jwt($signer, $jwtConfig);
    }
}