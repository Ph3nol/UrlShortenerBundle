<?php

namespace Sly\UrlShortenerBundle\Client;

/**
 * Curl client.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Curl implements CurlInterface
{
    /**
     * @var resource $curl
     */
    protected $curl;

    /**
     * @var string $url
     */
    protected $url;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->url = $url;

        curl_setopt($this->curl, CURLOPT_URL, $this->url);
    }

    /**
     * {@inheritdoc}
     */
    public function setGetData(array $getData = array())
    {
        $httpData = http_build_query($getData);

        curl_setopt($this->curl, CURLOPT_URL, $this->url.'?'.$httpData);
    }

    /**
     * {@inheritdoc}
     */
    public function setPostData(array $postData = array())
    {
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($postData));
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse($objectFormatted = true)
    {
        return $objectFormatted ? json_decode(curl_exec($this->curl)) : curl_exec($this->curl);
    }
}
