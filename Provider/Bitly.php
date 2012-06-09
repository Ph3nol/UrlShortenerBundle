<?php

namespace Sly\UrlShortenerBundle\Provider\Service;

use Buzz\Client\Curl;
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
     * @var Curl
     */
    protected $curl;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->curl = new Curl();
    }

    /**
     * Generate short URL.
     * 
     * @param string $longUrl Long URL
     * 
     * @return string
     */
    public static function generate($longUrl)
    {
        /**
         * @todo
         */
    }
}