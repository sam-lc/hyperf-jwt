<?php
/**
 * Class SignerFactory Description
 * Created by  PhpStorm.
 * Created Time 2020-01-06 11:46
 *
 * PHP version 7.1
 *
 * @category SignerFactory
 * @package  P:Samlc\HyperfJwt\SingerFactory
 * @author   lichao <lichao@xiaozhu.com>
 * @license  https://lanzu.xiaozhu.com Apache2 Licence
 * @link     https://lanzu.xiaozhu.com
 */

namespace Samlc\HyperfJwt\SingerFactory;

use Lcobucci\JWT\Signer;

interface SignerFactory
{
    public function sha256(): Signer;

    public function sha384(): Signer;

    public function sha512(): Signer;
}