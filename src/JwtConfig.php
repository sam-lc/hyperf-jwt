<?php
/**
 * Class JwtConfig Description
 * Created by  PhpStorm.
 * Created Time 2020-01-06 16:51
 *
 * PHP version 7.1
 *
 * @category JwtConfig
 * @package  P:Samlc\HyperfJwt
 * @author   lichao <lichao@xiaozhu.com>
 * @license  https://lanzu.xiaozhu.com Apache2 Licence
 * @link     https://lanzu.xiaozhu.com
 */

namespace Samlc\HyperfJwt;

class JwtConfig
{
    protected $ttl;
    protected $encryptKey;
    protected $decodeKey;
    protected $iss = null;
    protected $aud = null;
    protected $refreshTtl = 0;
    protected $sso = false;
    protected $invalid = false;

    /**
     * JwtConfig constructor.
     * @param int $ttl
     * @param string $encryptKey
     * @param string $decodeKey
     */
    public function __construct(int $ttl, string $encryptKey, string $decodeKey)
    {
        $this->ttl        = $ttl;
        $this->encryptKey = $encryptKey;
        $this->decodeKey  = $decodeKey;
    }

    /**
     * @param null $iss
     */
    public function setIss($iss): void
    {
        $this->iss = $iss;
    }

    /**
     * @param null $aud
     */
    public function setAud($aud): void
    {
        $this->aud = $aud;
    }

    /**
     * @param mixed $refreshTtl
     */
    public function setRefreshTtl($refreshTtl): void
    {
        $this->refreshTtl = $refreshTtl;
    }

    /**
     * @param bool $sso
     */
    public function setSso(bool $sso): void
    {
        $this->sso = $sso;
    }

    /**
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * @return string
     */
    public function getEncryptKey(): string
    {
        return $this->encryptKey;
    }

    /**
     * @return string
     */
    public function getDecodeKey(): string
    {
        return $this->decodeKey;
    }

    /**
     * @return null
     */
    public function getIss()
    {
        return $this->iss;
    }

    /**
     * @return null
     */
    public function getAud()
    {
        return $this->aud;
    }

    /**
     * @return int
     */
    public function getRefreshTtl(): int
    {
        return $this->refreshTtl;
    }

    /**
     * @return bool
     */
    public function isSso(): bool
    {
        return $this->sso;
    }
}
