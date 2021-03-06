<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Samlc\HyperfJwt;

use Samlc\HyperfJwt\Command\GenerateOpenSSLKey;
use Samlc\HyperfJwt\Contract\JwtInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                JwtInterface::class => JwtFactory::class,
            ],
            'commands'     => [
                GenerateOpenSSLKey::class
            ],
            'annotations'  => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'publish'      => [
                'id'          => 'config',
                'description' => 'The config for jwt.',
                'source'      => __DIR__ . '/../publish/jwt.php',
                'destination' => BASE_PATH . '/config/autoload/jwt.php',
            ]
        ];
    }
}
