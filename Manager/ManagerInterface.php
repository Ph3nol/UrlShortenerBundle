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
     * Get Link entity from linked object.
     *
     * @param object $object Object
     *
     * @return Link
     */
    public function getLinkEntityFromObject($object);

    /**
     * Get Link entity from long URL.
     *
     * @param string $longUrl Long URL
     *
     * @return Link
     */
    public function getLinkEntityFromLongUrl($longUrl);

    /**
     * Get Link entity from hash.
     *
     * @param string $hash Hash
     *
     * @return Link
     */
    public function getLinkEntityFromHash($hash);

    /**
     * Get internal links count.
     *
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
     * Create new Link from object.
     *
     * @param string $longUrl Long URL
     *
     * @return Link
     */
    public function createNewLinkFromUrl($longUrl);

    /**
     * Get short URL.
     *
     * @param mixed $item Item (hash, URL or object)
     *
     * @return string
     */
    public function getShortUrl($item);
}
