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
    CONST PROVIDER_NAME = 'googl';
    CONST API_URL       = 'https://www.googleapis.com/urlshortener/v1/url';

    /**
     * @var string
     */
    protected $creationData;

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
        $curlResquest->setUrl(self::API_URL);
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
