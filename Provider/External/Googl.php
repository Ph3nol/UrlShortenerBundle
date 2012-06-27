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
     */
    public function shorten($longUrl)
    {
        if (empty($longUrl)) {
            throw new \InvalidArgumentException('Provider can\'t create shortened URL without being based on long one');
        }

        $curlResquest = $this->curl;
        $curlResquest->setUrl(self::API_URL);

        if (isset($this->config['api']['key']) && $this->config['api']['key']) {
            $curlResquest->setGetData(array(
                'key' => $this->config['api']['key']
            ));
        }

        $curlResquest->setPostData(array(
            'longUrl' => $longUrl,
        ));

        try {
            $response = $curlResquest->getResponse();
        } catch (\Exception $e) {
            throw new \UnexpectedValueException(sprintf('Provider "%s" API seems to encounter a communication problem', self::PROVIDER_NAME));
        }

        if (empty($response->error) && isset($response->id)) {
            return array(
                'provider' => self::PROVIDER_NAME,
                'hash'     => $this->getHashFromShortUrl($response->id),
                'shortUrl' => $response->id,
                'longUrl'  => $longUrl,
            );
        } elseif (isset($response->error) && $response->error->code == 400) {
            throw new \UnexpectedValueException(sprintf('Provider "%s" API key seems to be invalid', ucfirst(self::PROVIDER_NAME)));
        } else {
            throw new \UnexpectedValueException(sprintf('Provider "%s" API short link creation has encountered a problem', self::PROVIDER_NAME));
        }
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
