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
     */
    public function __construct()
    {
        $this->curl = new Curl();
    }

    /**
     * Set configuration.
     * 
     * @param array $config Configuration
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }
}
