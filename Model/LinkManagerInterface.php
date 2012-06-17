<?php

namespace Sly\UrlShortenerBundle\Model;

use Sly\UrlShortenerBundle\Model\LinkInterface;

/**
 * LinkManager interface.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface LinkManagerInterface
{
    /**
     * Get one from object.
     * 
     * @param object $object Object
     * 
     * @return LinkInterface
     */
    public function getOneFromObject($object);

    /**
     * Get one from long URL.
     * 
     * @param string $longUrl Long URL
     * 
     * @return LinkInterface
     */
    public function getOneFromLongUrl($longUrl);

    /**
     * Get one from hash.
     * 
     * @param string $hash Hash
     * 
     * @return LinkInterface
     */
    public function getOneFromHash($hash);

    /**
     * Get one internal from hash.
     * 
     * @param string $hash Hash
     * 
     * @return LinkInterface
     */
    public function getOneInternalFromHash($hash);

    /**
     * Get internal links count.
     * 
     * @return integer
     */
    public function getInternalCount();

    /**
     * Create new Link.
     * 
     * @param array  $config        Configuration
     * @param array  $shortenerData Data from Shortener service
     * @param object $object        Object (if it is)
     * 
     * @return LinkInterface
     */
    public function create(array $config, array $shortenerData, $object = null);
}
