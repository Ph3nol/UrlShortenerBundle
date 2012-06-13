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
     * @param string $url
     *
     * @return void
     */
    public function setUrl($url);

    /**
     * @param array $getData GET data
     */
    public function setGetData(array $getData = array());

    /**
     * @param array $postData POST data
     *
     * @return void
     */
    public function setPostData(array $postData = array());

    /**
     * @param boolean $objectFormatted Object formatted
     *
     * @return mixed
     */
    public function getResponse($objectFormatted = true);
}
