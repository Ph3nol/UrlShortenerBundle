<?php

namespace Sly\UrlShortenerBundle\Shortener;

use Sly\UrlShortenerBundle\Provider\ProviderInterface;

/**
 * Shortener service interface.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface ShortenerInterface
{
    /**
     * Initialize with right loading provider.
     *
     * @param array $config
     */
    public function initialize(array $config);

    /**
     * Create short URL.
     *
     * @param string $longUrl Long URL
     *
     * @return string
     */
    public function shorten($longUrl);

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
