<?php

namespace Sly\UrlShortenerBundle\Model;


/**
 * Link model.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Link implements LinkInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var object
     */
    protected $object;

    /**
     * @var string
     */
    protected $objectEntity;

    /**
     * @var integer
     */
    protected $objectId;

    /**
     * @var integer
     */
    protected $provider;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var string
     */
    protected $shortUrl;

    /**
     * @var string
     */
    protected $longUrl;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function setObject($object)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('You must pass an object for URL shortening');
        }

        $this->object = $object;
        $this->setObjectEntity(get_class($object));
        $this->setObjectId($object->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function setObjectEntity($objectEntity)
    {
        $this->objectEntity = $objectEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;
    }

    /**
     * {@inheritdoc}
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * {@inheritdoc}
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * {@inheritdoc}
     */
    public function getShortUrl()
    {
        return $this->shortUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function setShortUrl($shortUrl)
    {
        $this->shortUrl = $shortUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function getLongUrl()
    {
        return $this->longUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function setLongUrl($longUrl)
    {
        $this->longUrl = $longUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return array(
            'id',
            'service',
            'hash',
            'shortUrl',
            'longUrl',
            'createdAt',
        );
    }
}
