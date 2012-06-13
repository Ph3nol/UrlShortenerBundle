<?php

namespace Sly\UrlShortenerBundle\Shortener;

/**
 * Shortener service interface.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface ShortenerInterface
{
    /**
     * Set Provider instance.
     *
     * @param string $config
     */
    public function setProvider(array $config);

    /**
     * @param string $longUrl Long URL
     *
     * @return string
     */
    public function createShortUrl($longUrl);

    /**
     * @param integer $bitNumber Bit number
     *
     * @return string
     */
    public static function getHashFromBit($bitNumber = 1);
}
