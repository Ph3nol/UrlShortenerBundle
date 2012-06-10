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
    protected $apiUrl;

    /**
     * @var string
     */
    protected $longUrl;

    /**
     * @var string
     */
    protected $creationData;

    /**
     * Constructor.
     * 
     * @param array $apiData API data passed from bundle configuration file
     */
    public function __construct(array $apiData)
    {
        $this->apiUsername = $apiData['username'];
        $this->apiKey      = $apiData['key'];
        $this->apiUrl      = sprintf('http://api.bitly.com/v3/shorten?login=%s&apiKey=%s&longUrl=', $this->apiUsername, $this->apiKey);
    }

    /**
     * Set long URL.
     * 
     * @param string $longUrl Long URL
     */
    public function setLongUrl($longUrl)
    {
        $this->longUrl = $longUrl;
        $this->apiUrl  .= urlencode($this->longUrl);
    }

    /**
     * Create short URL from API.
     * 
     * @return object
     */
    public function create()
    {
        if (!$this->longUrl) {
            throw new \InvalidArgumentException('Provider can\'t create shortened URL without being based on long one');
        }

        $browser         = new Browser();
        $response        = $browser->get($this->apiUrl);
        $responseContent = json_decode($response->getContent());

        if ($responseContent->status_code == 200 && $responseContent->status_txt == 'OK') {
            $this->creationData = $responseContent->data;
        }

        return $this->creationData;
    }
}