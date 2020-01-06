<?php
/**
 * Class RasFactory Description
 * Created by  PhpStorm.
 * Created Time 2020-01-06 11:15
 *
 * PHP version 7.1
 *
 * @category RasFactory
 * @package  P:Samlc\HyperfJwt\SingerFactory
 * @author   lichao <lichao@xiaozhu.com>
 * @license  https://lanzu.xiaozhu.com Apache2 Licence
 * @link     https://lanzu.xiaozhu.com
 */

namespace Samlc\HyperfJwt\SingerFactory;

use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Rsa;

class RasFactory implements SignerFactory
{
    public function sha256(): Signer
    {
        return new Rsa\Sha256();
    }

    public function sha384(): Signer
    {
        return new Rsa\sha384();
    }

    public function sha512(): Signer
    {
        return new Rsa\sha512();
    }
}