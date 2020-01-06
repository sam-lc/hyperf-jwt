<?php
/**
 * Class JwtFactoryTest Description
 * Created by  PhpStorm.
 * Created Time 2020-01-06 13:27
 *
 * PHP version 7.1
 *
 * @category JwtFactoryTest
 * @package  P:HyperfTest\Cases
 * @author   lichao <lichao@xiaozhu.com>
 * @license  https://lanzu.xiaozhu.com Apache2 Licence
 * @link     https://lanzu.xiaozhu.com
 */

declare(strict_types=1);

namespace HyperfTest\Cases;

use Samlc\HyperfJwt\Jwt;
use Samlc\HyperfJwt\JwtFactory;

final class JwtFactoryTest extends AbstractTestCase
{
    public function testJwt()
    {
        $jwt = new JwtFactory();
        $this->assertInstanceOf(
            Jwt::class,
            $jwt()
        );
        return $jwt;
    }
}