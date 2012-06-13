<?php

namespace Sly\UrlShortenerBundle\Manager;

/**
 * Manager interface.
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
     * @param string $longUrl Long URL
     *
     * @return Link
     */
    public function getLinkEntityFromLongUrl($longUrl);

    /**
     * @param string $hash Hash
     *
     * @return Link
     */
    public function getLinkEntityFromHash($hash);

    /**
     * @return integer
     */
    public function getInternalLinksCount();

    /**
     * @param object $object Object
     *
     * @return Link
     */
    public function createNewLinkFromObject($object);

    /**
     * @param string $longUrl Long URL
     *
     * @return Link
     */
    public function createNewLinkFromUrl($longUrl);

    /**
     * @param mixed $item Item (hash, URL or object)
     *
     * @return string
     */
    public function getShortUrl($item);
}
