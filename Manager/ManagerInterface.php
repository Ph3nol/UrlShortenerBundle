<?php

namespace Sly\UrlShortenerBundle\Manager;

use Sly\UrlShortenerBundle\Model\LinkInterface;

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
     * @return LinkInterface
     */
    public function createNewLinkFromObject($object);

    /**
     * Create new Link from object.
     *
     * @param string $longUrl Long URL
     *
     * @return LinkInterface
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
