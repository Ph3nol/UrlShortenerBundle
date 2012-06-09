<?php

namespace Sly\UrlShortenerBundle\Provider;

use Sly\UrlShortenerBundle\Provider;

/**
 * Bitly provider.
 * For bit.ly URL shortener service.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Bitly implements ProviderInterface
{
    /**
     * Generate short URL.
     * 
     * @param string $longUrl Long URL
     * 
     * @return string
     */
    public static function generate($longUrl)
    {
        $request = new \Buzz\Message\Request('HEAD', '/', 'http://google.com');
        $response = new \Buzz\Message\Response();
    }
}