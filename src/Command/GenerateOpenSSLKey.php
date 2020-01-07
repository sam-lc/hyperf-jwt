<?php
/**
 * Class GenerateRsaKey Description
 * Created by  PhpStorm.
 * Created Time 2020-01-03 16:16
 *
 * PHP version 7.1
 *
 * @category GenerateRsaKey
 * @package  P:Samlc\HyperfJwt\Command
 * @author   lichao <lichao@xiaozhu.com>
 * @license  https://lanzu.xiaozhu.com Apache2 Licence
 * @link     https://lanzu.xiaozhu.com
 */

namespace Samlc\HyperfJwt\Command;

use Hyperf\Command\Command;

class GenerateOpenSSLKey extends Command
{
    protected $name = 'gen:opensslKey';

    /**
     * Fun handle Description
     * Created Time 2020-01-06 18:33
     * Author lichao <lichao@xiaozhu.com>
     */
    public function handle()
    {
        $key     = $this->newKey();
        $keyPath = BASE_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'key';
        if (!is_dir($keyPath)) {
            mkdir($keyPath);
        }
        file_put_contents($keyPath . DIRECTORY_SEPARATOR . 'private.key', $this->generatePrivateKey($key));
        file_put_contents($keyPath . DIRECTORY_SEPARATOR . 'public.key', $this->generatePublicKey($key));
    }

    /**
     * Fun generatePrivateKey 生成私钥
     * Created Time 2020-01-06 18:25
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param $key
     *
     * @return string
     */
    protected function generatePrivateKey($key): string
    {
        openssl_pkey_export($key, $privateKey);
        return $privateKey;
    }

    /**
     * Fun generatePublicKey 生成公钥
     * Created Time 2020-01-06 18:25
     * Author lichao <lichao@xiaozhu.com>
     *
     * @param $key
     *
     * @return mixed
     */
    protected function generatePublicKey($key)
    {
        return openssl_pkey_get_details($key)['key'];
    }

    /**
     * Fun newKey Description
     * Created Time 2020-01-03 16:53
     * Author lichao <lichao@xiaozhu.com>
     *
     *
     * @return resource
     */
    protected function newKey()
    {
        return openssl_pkey_new([
            'digest_alg'       => "sha256",
            'private_key_bits' => 1024,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ]);
    }
}