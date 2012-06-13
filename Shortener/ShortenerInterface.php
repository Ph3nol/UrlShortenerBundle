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
     * Create short URL.
     *
     * @param string $longUrl Long URL
     *
     * @return string
     */
    public function createShortUrl($longUrl);

    /**
     * Get hash from bit.
     * The trick is to create your own base system with a custom set of characters.
     *
     * @param integer $bitNumber Bit number
     *
     * @return string
     */
    public static function getHashFromBit($bitNumber = 1);
}
