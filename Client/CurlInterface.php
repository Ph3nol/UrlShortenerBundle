<?php

namespace Sly\UrlShortenerBundle\Client;

/**
 * Curl interface.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface CurlInterface
{
    /**
     * Set URL.
     *
     * @param string $url
     */
    public function setUrl($url);

    /**
     * Set GET data.
     *
     * @param array $getData GET data
     */
    public function setGetData(array $getData = array());

    /**
     * Set POST data.
     *
     * @param array $postData POST data
     */
    public function setPostData(array $postData = array());

    /**
     * Get CURL response.
     *
     * @param boolean $objectFormatted Object formatted
     *
     * @return mixed
     */
    public function getResponse($objectFormatted = true);
}
