<?php
/**
 * Class JwtInterface Description
 * Created by  PhpStorm.
 * Created Time 2020-01-06 11:19
 *
 * PHP version 7.1
 *
 * @category JwtInterface
 * @package  P:Samlc\HyperfJwt\Contract
 * @author   lichao <lichao@xiaozhu.com>
 * @license  https://lanzu.xiaozhu.com Apache2 Licence
 * @link     https://lanzu.xiaozhu.com
 */

namespace Samlc\HyperfJwt\Contract;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;

interface JwtInterface
{
    /**
     * Fun generate 生成token
     * Created Time 2020-01-06 15:47
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param array $claims
     *
     * @return Token
     */
    public function generate(array $claims = []): Token;

    /**
     * Fun setValidationData 设置验证对象
     * Created Time 2020-01-06 15:47
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param ValidationData $validationData
     *
     * @return JwtInterface
     */
    public function setValidationData(ValidationData $validationData): self;

    /**
     * Fun verify 验证
     * Created Time 2020-01-06 15:47
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param string $token
     *
     * @return bool
     */
    public function verify(string $token): bool;

    /**
     * Fun refresh 在允许刷新时间内，刷新token
     * Created Time 2020-01-06 17:17
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param string $token
     *
     * @return Token
     */
    public function refresh(string $token): Token;
}