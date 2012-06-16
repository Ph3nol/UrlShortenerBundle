<?php

namespace Sly\UrlShortenerBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sly\UrlShortenerBundle\Config\ConfigInterface;
use Sly\UrlShortenerBundle\Shortener\Shortener;
use Sly\UrlShortenerBundle\Shortener\ShortenerInterface;
use Sly\UrlShortenerBundle\Router\Router;
use Sly\UrlShortenerBundle\Router\RouterInterface;
use Sly\UrlShortenerBundle\Model\LinkInterface;
use Sly\UrlShortenerBundle\Entity\Link;
use Sly\UrlShortenerBundle\Provider\Internal;
use Sly\UrlShortenerBundle\Provider\Bitly;
use Sly\UrlShortenerBundle\Provider\Googl;

/**
 * Manager service.
 *
 * @uses BaseManager
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Manager extends BaseManager implements ManagerInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ShortenerInterface
     */
    protected $shortener;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param object             $linkManager Link manager service
     * @param ShortenerInterface $shortener   Shortener service
     * @param RouterInterface    $router      Bundle Router service
     * @param ConfigInterface    $config      Configuration service
     */
    public function __construct($linkManager, ShortenerInterface $shortener, RouterInterface $router, ConfigInterface $config)
    {
        $this->linkManager = $linkManager;
        $this->shortener   = $shortener;
        $this->router      = $router;
        $this->config      = $config;
    }

    /**
     * Get link entity from object.
     * 
     * @param object $object
     * 
     * @return LinkInterface
     */
    protected function getLinkEntityFromObject($object)
    {
        $objectEntityClass = get_class($object);

        if (false === $this->config->getEntities()->has($objectEntityClass)) {
            throw new \Exception(sprintf('There is no "%s" entity in UrlShortener bundle configuration', $objectEntityClass));
        }

        return $this->linkManager->getOneFromObject($object);
    }

    /**
     * {@inheritdoc}
     */
    public function createNewLinkFromObject($object)
    {
        $objectEntityName = get_class($object);
        $this->config     = $this->config->getEntity($objectEntityName);

        $this->shortener->setProvider($this->config);

        $longUrl       = $this->router->getObjectShowRoute($object, $this->config['route']);
        $shortenerData = $this->shortener->createShortUrl($longUrl);
        
        return $this->linkManager->create($this->config, $shortenerData, $object);
    }

    /**
     * {@inheritdoc}
     */
    public function createNewLinkFromUrl($longUrl)
    {
        $this->shortener->setProvider($this->config->getConfig());

        $shortenerData = $this->shortener->createShortUrl($longUrl);

        return $this->linkManager->create($this->config->getConfig(), $shortenerData);
    }

    /**
     * {@inheritdoc}
     */
    public function getShortUrl($item)
    {
        if (is_object($item)) {
            return $this->getShortUrlFromObject($item);
        }

        if (preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $item)) {
            return $this->getShortUrlFromLongUrl($item);
        }

        return $this->getShortUrlFromHash($item);
    }

    /**
     * Get from Url.
     *
     * @param object $object Entity object
     *
     * @return string|null
     */
    protected function getShortUrlFromObject($object)
    {
        if ($link = $this->getLinkEntityFromObject($object)) {
            return $link->getShortUrl();
        } else {
            if ($newShortLink = $this->createNewLinkFromObject($object)) {
                return $newShortLink->getShortUrl();
            }
        }
    }

    /**
     * Get short URL from long one.
     *
     * @param string $longUrl Long URL
     *
     * @return string|null
     */
    protected function getShortUrlFromLongUrl($longUrl)
    {
        if ($link = $this->linkManager->getOneFromLongUrl($longUrl)) {
            return $link->getShortUrl();
        } else {
            if ($newShortLink = $this->createNewLinkFromUrl($longUrl)) {
                return $newShortLink->getShortUrl();
            }
        }
    }

    /**
     * Get short URL from hash.
     *
     * @param string $hash Hash
     *
     * @return string|null
     */
    protected function getShortUrlFromHash($hash)
    {
        if ($link = $this->linkManager->getOneFromHash($hash)) {
            return $link->getShortUrl();
        }
    }
}
