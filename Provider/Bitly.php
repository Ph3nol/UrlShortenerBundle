<?php

namespace Sly\UrlShortenerBundle\Provider;

use Buzz\Browser;
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
     * @var string
     */
    protected $apiUsername;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $longUrl;

    /**
     * Constructor.
     * 
     * @param array  $apiData API data passed from bundle configuration file
     */
    public function __construct(array $apiData)
    {
        $this->apiUsername = $apiData['username'];
        $this->apiKey      = $apiData['key'];
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
     * @return string
     */
    public function create()
    {
        if (!$this->longUrl) {
            throw new \InvalidArgumentException('Provider can\'t create shortened URL without being based on long one');
        }

        /**
         * @todo
         */
    }
}