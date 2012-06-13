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
     */
    public function __construct(array $config = array())
    {
        $this->curl   = new Curl();
        $this->config = $config;
    }
}
