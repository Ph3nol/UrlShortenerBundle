<?php

namespace Sly\UrlShortenerBundle\Model;

/**
 * Link interface.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface LinkInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param integer $id
     */
    public function setId($id);

    /**
     * @param object $object
     */
    public function setObject($object);

    /**
     * @param string $objectEntity
     */
    public function setObjectEntity($objectEntity);

    /**
     * @param string $objectId
     */
    public function setObjectId($objectId);

    /**
     * @return string
     */
    public function getHash();

    /**
     * @param string $hash
     */
    public function setHash($hash);

    /**
     * @return string
     */
    public function getShortUrl();

    /**
     * @param string $shortUrl
     */
    public function setShortUrl($shortUrl);

    /**
     * @return string
     */
    public function getLongUrl();

    /**
     * @param string $longUrl
     */
    public function setLongUrl($longUrl);

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt);

    /**
     * @return DateTime
     */
    public function getCreatedAt();
}