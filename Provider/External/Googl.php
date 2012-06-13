<?php

namespace Sly\UrlShortenerBundle\Provider\External;

use Sly\UrlShortenerBundle\Provider\BaseProvider;
use Sly\UrlShortenerBundle\Provider\ProviderInterface;

/**
 * Googl provider.
 * For goog.gl URL shortener service.
 *
 * @uses BaseProvider
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Googl extends BaseProvider implements ProviderInterface
{
    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * @var string
     */
    protected $creationData;

    /**
     * Constructor.
     * 
     * @param array $config Configuration
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->apiUrl = 'https://www.googleapis.com/urlshortener/v1/url';
    }

    /**
     * Create short URL from API.
     * 
     * @return array
     */
    public function shorten()
    {
        parent::shorten();

        $curlResquest = $this->curl;
        $curlResquest->setUrl($this->apiUrl);
        $curlResquest->setPostData(array('longUrl' => $this->longUrl));

        $response = $curlResquest->getResponse();

        return array(
            'hash'     => $this->getHashFromShortUrl($response->id),
            'shortUrl' => $response->id,
        );
    }

    /**
     * Get hash from short URL.
     * 
     * @param string $shortUrl Short URL
     * 
     * @return string
     */
    protected function getHashFromShortUrl($shortUrl)
    {
        $shortUrl = explode('/', $shortUrl);

        return $shortUrl[count($shortUrl) - 1];
    }
}