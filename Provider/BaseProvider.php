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
     * @var array $params
     */
    protected $params;

    /**
     * @var string
     */
    protected $longUrl;

    /**
     * Constructor.
     * 
     * @param array $apiData Provider API data from project configuration file
     * @param array $params  Provider parameters
     * 
     * @return void
     */
    public function __construct(array $apiData = array(), array $params = array())
    {
        $this->curl   = new Curl();
        $this->params = $params;
    }

    /**
     * Set long URL.
     * 
     * @param string $longUrl Long URL
     */
    public function setLongUrl($longUrl)
    {
        $this->longUrl = $longUrl;
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