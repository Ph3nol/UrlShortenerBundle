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
     * @var array $config
     */
    protected $config;

    /**
     * @var string
     */
    protected $longUrl;

    /**
     * Constructor.
     *
     * @param array $config Configuration
     *
     * @return void
     */
    public function __construct(array $config = array())
    {
        $this->curl   = new Curl();
        $this->config = $config;
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
