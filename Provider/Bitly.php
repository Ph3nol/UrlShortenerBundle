<?php

namespace Sly\UrlShortenerBundle\Provider;

/**
 * Bitly provider.
 * For bit.ly URL shortener service.
 *
 * @uses BaseProvider
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Bitly extends BaseProvider implements ProviderInterface
{
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
    protected $apiUrl;

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
        parent::__construct();

        $this->apiLogin = $apiData['username'];
        $this->apiKey   = $apiData['key'];
        $this->apiUrl   = 'http://api.bitly.com/v3/shorten';
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
        $curlResquest->setGetData(array('longUrl' => $this->longUrl, 'login' => $this->apiLogin, 'apiKey' => $this->apiKey));

        $response = $curlResquest->getResponse();

        if ($response->status_code == 200 && $response->status_txt == 'OK') {
            return array(
                'hash'     => $response->data->hash,
                'shortUrl' => $response->data->url,
            );
        } else {
            return null;
        }
    }
}