<?php
/**
 * Class EcdsaFactory Description
 * Created by  PhpStorm.
 * Created Time 2020-01-06 11:44
 *
 * PHP version 7.1
 *
 * @category EcdsaFactory
 * @package  P:Samlc\HyperfJwt\SingerFactory
 * @author   lichao <lichao@xiaozhu.com>
 * @license  https://lanzu.xiaozhu.com Apache2 Licence
 * @link     https://lanzu.xiaozhu.com
 */

namespace Samlc\HyperfJwt\SingerFactory;

use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Ecdsa;

class EcdsaFactory implements SignerFactory
{
    public function sha256(): Signer
    {
        return new Ecdsa\Sha256();
    }

    public function sha384(): Signer
    {
        return new Ecdsa\sha384();
    }

    public function sha512(): Signer
    {
        return new Ecdsa\sha512();
    }
}