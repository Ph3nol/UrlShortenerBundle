<?php

namespace Sly\UrlShortenerBundle\Model;

use Symfony\Component\HttpFoundation\Request;

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
    protected $objectModel;

    /**
     * @var integer
     */
    protected $objectId;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt     = new \DateTime();
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
     * 
     * @param object $object Object
     */
    public function setObject($object)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('You must pass an object for URL shortening');
        }

        $this->object = $object;
        $this->setObjectModel(get_class($object));
        $this->setObjectId($object->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function setObjectModel($objectModel)
    {
        $this->objectModel = $objectModel;
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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->url = $url;
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
            'hash',
            'url',
            'createdAt',
        );
    }
}