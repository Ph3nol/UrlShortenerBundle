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
     * @param string $longUrl Long URL
     */
    public function __construct(array $apiData, $longUrl)
    {
        $this->apiUsername = $apiData['username'];
        $this->apiKey      = $apiData['key'];
        $this->longUrl     = $longUrl;
    }
    /**
     * Create short URL from API.
     * 
     * @return string
     */
    public static function create()
    {
        $request = new \Buzz\Message\Request('HEAD', '/', 'http://slynett.com');
        $response = new \Buzz\Message\Response();

        $client = new \Buzz\Client\FileGetContents();
        $client->send($request, $response);
    }
}