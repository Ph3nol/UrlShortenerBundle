<?php

namespace Sly\UrlShortenerBundle\Provider\External;

use Sly\UrlShortenerBundle\Provider\BaseProvider;
use Sly\UrlShortenerBundle\Provider\ProviderInterface;

/**
 * Bitly provider.
 * For bit.ly URL shortener service.
 *
 * @uses BaseProvider
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Bitly extends BaseProvider implements ProviderInterface
{
    CONST PROVIDER_NAME = 'bitly';
    CONST API_URL       = 'http://api.bitly.com/v3/shorten';

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
        $curlResquest->setGetData(array(
            'longUrl' => $longUrl,
            'login'   => $this->config['api']['username'],
            'apiKey'  => $this->config['api']['key'],
        ));

        $response = $curlResquest->getResponse();

        if ($response->status_code == 200 && $response->status_txt == 'OK') {

            return array(
                'provider' => self::PROVIDER_NAME,
                'hash'     => $response->data->hash,
                'shortUrl' => $response->data->url,
                'longUrl'  => $longUrl,
            );
        }

        return null;
    }
}
