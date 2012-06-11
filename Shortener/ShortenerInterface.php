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
     * @param array $providerParams Provider parameters
     */
    public function setProviderParams(array $providerParams = array());

    /**
     * @param string $provider        Provider name
     * @param array  $providerApiData Provider API data from project configuration file
     */
    public function setProvider($provider, array $providerApiData = array());

    /**
     * @param string $longUrl Long URL
     * 
     * @return string
     */
    public function createShortUrl($longUrl);

    /**
     * @param integer $bit Bit number
     * 
     * @return string
     */
    public static function getHashFromBit($bitNumber = 1);
}