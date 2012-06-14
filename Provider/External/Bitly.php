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
    CONST API_URL = 'http://api.bitly.com/v3/shorten';

    /**
     * @var string
     */
    protected $apiLogin;

    /**
     * @var string
     */
    protected $apiKey;

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
    public function __construct(array $config)
    {
        parent::__construct();

        $this->apiLogin = $config['api_username'];
        $this->apiKey   = $config['api_key'];
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
        $curlResquest->setUrl(self::API_URL);
        $curlResquest->setGetData(array('longUrl' => $this->longUrl, 'login' => $this->apiLogin, 'apiKey' => $this->apiKey));

        $response = $curlResquest->getResponse();

        if ($response->status_code == 200 && $response->status_txt == 'OK') {

            return array(
                'hash'     => $response->data->hash,
                'shortUrl' => $response->data->url,
            );
        }

        return null;
    }
}
