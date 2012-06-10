<?php

namespace Sly\UrlShortenerBundle\Provider;

use Sly\UrlShortenerBundle\Client\Curl;

/**
 * BaseProvider.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
abstract class BaseProvider
{
    /**
     * @var Curl $curl
     */
    protected $curl;

    /**
     * Constructor.
     * 
     * @param array $apiData Provider API data from project configuration file
     * 
     * @return void
     */
    public function __construct(array $apiData = array())
    {
        $this->curl = new Curl();
    }

    /**
     * Create short URL from API.
     * 
     * @return void
     */
    public function shorten()
    {
        if (!$this->longUrl) {
            throw new \InvalidArgumentException('Provider can\'t create shortened URL without being based on long one');
        }
    }
}