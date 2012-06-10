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
}