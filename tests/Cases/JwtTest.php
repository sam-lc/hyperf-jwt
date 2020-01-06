<?php
/**
 * Class JwtTest Description
 * Created by  PhpStorm.
 * Created Time 2020-01-06 13:48
 *
 * PHP version 7.1
 *
 * @category JwtTest
 * @package  P:HyperfTest\Cases
 * @author   lichao <lichao@xiaozhu.com>
 * @license  https://lanzu.xiaozhu.com Apache2 Licence
 * @link     https://lanzu.xiaozhu.com
 */

namespace HyperfTest\Cases;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;
use Samlc\HyperfJwt\Jwt;
use Samlc\HyperfJwt\JwtFactory;

class JwtTest extends AbstractTestCase
{
    /**
     * @var Jwt
     */
    protected $jwt;

    protected function setUp()
    {
        $jwt       = new JwtFactory();
        $this->jwt = $jwt();
    }

    public function testGenerate()
    {
        $token = $this->jwt->generate(['uid' => 1]);
        $this->assertInstanceOf(
            Token::class,
            $token
        );
        return (string)$token;
    }

    /**
     * @depends      testGenerate
     * @dataProvider verifyProvider
     */
    public function testVerify(string $audience, bool $result, string $token)
    {
        $validate = new ValidationData();
        $validate->setAudience($audience);
        $this->jwt->setValidationData($validate);
        $this->assertEquals($result, $this->jwt->verify($token));
//        $this->assertTrue(
//            $this->jwt->verify($token)
//        );
    }

    public function verifyProvider()
    {
        return [
            [
                'http://test.example',
                false
            ],
            [
                'http://localhost',
                true
            ]
        ];
    }

}