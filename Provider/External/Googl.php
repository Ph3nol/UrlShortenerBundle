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
    public function __construct(array $config = array())
    {
        parent::__construct($config);

        $this->apiUrl = 'https://www.googleapis.com/urlshortener/v1/url';
    }

    /**
     * {@inheritdoc}
     * Create short URL from Googl API.
     */
    public function shorten($longUrl)
    {
        if (empty($longUrl)) {
            throw new \InvalidArgumentException('Provider can\'t create shortened URL without being based on long one');
        }

        $curlResquest = $this->curl;
        $curlResquest->setUrl($this->apiUrl);
        $curlResquest->setPostData(array(
            'longUrl' => $longUrl,
        ));

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
