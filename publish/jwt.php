<?php
/**
 * Class ${NAME} Description
 * Created by  PhpStorm.
 * Created Time 2020-01-03 16:39
 *
 * PHP version 7.1
 *
 * @category ${NAME}
 * @author   lichao <lichao@xiaozhu.com>
 * @license  https://lanzu.xiaozhu.com Apache2 Licence
 * @link     https://lanzu.xiaozhu.com
 */

declare(strict_types=1);

return [
    'ttl'            => env('JWT_TTL', 3600),           //token有效时长，秒
    'refresh_ttl'    => env('JWT_REFRESH_TTL', 7200),   //允许token刷新时间，秒
    'sign_type'      => env('JWT_SING_TYPE', 'rsa'), //签名类型，支持：rsa,ecdsa,hmac
    'sign_algorithm' => env('JWR_SING_ALGORITHM', 'sha256'), //签名算法，支持：sha256,sha384,sha512
    'key'            => [
        'encrypt' => env('JWR_PRIVATE_KEY', 'file://./key/private.key'),
        'decode'  => env('JWR_PUBLIC_KEY', 'file://./key/public.key'),
    ],
    'aud'            => env('JWT_AUD', 'http://localhost'), //受众
    'iat'            => env('JWT_IAT', 'your@email.com'),   //签发人
    'sso'            => env('JWT_SSO', false),              //单点登录，借助redis实现
];