<?php

namespace Sly\UrlShortenerBundle\Client;

use Buzz\Client\Curl as BaseCurl;
use Buzz\Message;

/**
 * Curl client.
 *
 * @uses BaseCurl
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Curl extends BaseCurl
{
    static protected function setCurlOptsFromRequest($curl, Message\Request $request)
    {
        parent::setCurlOptsFromRequest($curl, $request);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    }
}
