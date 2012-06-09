<?php

namespace Sly\UrlShortenerBundle\Manager;

/**
 * Manager service.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface ManagerInterface
{
    /**
     * @param object $object Object
     * 
     * @return Link
     */
    public function getLinkEntityFromObject($object);

    /**
     * @param string $hash Hash
     * 
     * @return Link
     */
    public function getLongUrlFromHash($hash);

    /**
     * @param string $shortUrl Short URL
     * 
     * @return Link
     */
    public function getLongUrlFromShortUrl($shortUrl);

    /**
     * @param string $url Long URL
     * 
     * @return Link
     */
    public function getHashFromLongUrl($url);

    /**
     * @param object $object Object
     * 
     * @return Link
     */
    public function createNewLink($object);
}