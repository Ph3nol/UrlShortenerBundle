<?php

namespace Sly\UrlShortenerBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sly\UrlShortenerBundle\Model\EntityCollection;
use Sly\UrlShortenerBundle\Shortener\Shortener;
use Sly\UrlShortenerBundle\Shortener\ShortenerInterface;
use Sly\UrlShortenerBundle\Router\Router;
use Sly\UrlShortenerBundle\Router\RouterInterface;
use Sly\UrlShortenerBundle\Entity\Link;
use Sly\UrlShortenerBundle\Provider\Internal,
    Sly\UrlShortenerBundle\Provider\Bitly,
    Sly\UrlShortenerBundle\Provider\Googl;

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
     * @var array
     */
    protected $config;

    /**
     * @var EntityCollection
     */
    protected $configEntities;

    /**
     * Constructor.
     * 
     * @param EntityManager      $em        Entity Manager service
     * @param ShortenerInterface $shortener Shortener service
     * @param RouterInterface    $router    Bundle Router service
     * @param array              $config    Bundle configuration
     */
    public function __construct(EntityManager $em, ShortenerInterface $shortener, RouterInterface $router, array $config)
    {
        $this->em             = $em;
        $this->shortener      = $shortener;
        $this->router         = $router;
        $this->config         = $config;
        $this->configEntities = $this->setConfigEntitiesCollection();
    }

    /**
     * Set config entities collection.
     * 
     * @return EntityCollection
     */
    public function setConfigEntitiesCollection()
    {
        $configEntities = new EntityCollection();

        foreach ($this->config['entities'] as $name => $data) {
            $configEntities->set($name, $data);
        }

        return $configEntities;
    }

    /**
     * Get Link entity from linked object.
     * 
     * @param object $object Object
     * 
     * @return Link
     */
    public function getLinkEntityFromObject($object)
    {
        $objectEntityClass = get_class($object);

        if (false === $this->configEntities->has($objectEntityClass)) {
            throw new \Exception(sprintf('There is no "%s" entity in UrlShortener bundle configuration', $objectEntityClass));
        }

        $q = $this->getRepository()
                ->createQueryBuilder('l')
                ->where('l.objectEntity = :objectEntity')
                ->andWhere('l.objectId = :objectId')
                ->setParameters(array(
                    'objectEntity' => get_class($object),
                    'objectId'     => $object->getId(),
                ));

        return $q->getQuery()->getOneOrNullResult();
    }

    /**
     * Get Link entity from long URL.
     * 
     * @param string $longUrl Long URL
     * 
     * @return Link
     */
    public function getLinkEntityFromLongUrl($longUrl)
    {
        $q = $this->getRepository()
                ->createQueryBuilder('l')
                ->where('l.longUrl = :longUrl')
                ->setParameter('longUrl', $longUrl);

        return $q->getQuery()->getOneOrNullResult();
    }

    /**
     * Get Link entity from hash.
     * 
     * @param string $hash Hash
     * 
     * @return Link
     */
    public function getLinkEntityFromHash($hash)
    {
        $q = $this->getRepository()
                ->createQueryBuilder('l')
                ->where('l.hash = :hash')
                ->setParameter('hash', $hash);

        return $q->getQuery()->getOneOrNullResult();
    }

    /**
     * Get internal links count.
     * 
     * @return integer
     */
    public function getInternalLinksCount()
    {
        $q = $this->getRepository()
                ->createQueryBuilder('l')
                ->where('l.provider = :internalProvider')
                ->setParameter('internalProvider', 'internal');

        return count($q->getQuery());
    }

    /**
     * Create new Link.
     * 
     * @param object $object Object
     * 
     * @return Link
     */
    public function createNewLink($object)
    {
        $objectEntityClass       = get_class($object);
        $objectEntityConfig      = $this->configEntities->getEntities()->offsetGet($objectEntityClass);
        $providerApiInformations = isset($objectEntityConfig['api']) ? $objectEntityConfig['api'] : null;
        $providerParams          = isset($objectEntityConfig['params']) ? $objectEntityConfig['params'] : array();

        $providerParams['internalLinksCount'] = $this->getInternalLinksCount();
        $this->shortener->setProviderParams($providerParams);

        $this->shortener->setProvider(
            $objectEntityConfig['provider'],
            isset($providerApiInformations) ? $providerApiInformations : array()
        );

        $longUrl = $this->router->getObjectShowRoute($object, $objectEntityConfig['route']);

        if ($createdShortUrl = $this->shortener->createShortUrl($longUrl)) {
            $link = new Link();
            $link->setObjectEntity(get_class($object));
            $link->setObjectId($object->getId());
            $link->setShortUrl($createdShortUrl['shortUrl']);
            $link->setLongUrl($longUrl);
            $link->setHash($createdShortUrl['hash']);
            $link->setProvider($objectEntityConfig['provider']);

            $this->em->persist($link);
            $this->em->flush($link);
        } else {
            return false;
        }

        return $link;
    }

    /**
     * Get short URL.
     * 
     * @param mixed $item Item (hash, URL or object)
     * 
     * @return string
     */
    public function getShortUrl($item)
    {
        if (is_object($item)) {
            return $this->getShortUrlFromObject($item);
        } else {
            if (preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $item)) {
                return $this->getShortUrlFromLongUrl($item);
            } else {
                return $this->getShortUrlFromHash($item);
            }
        }
    }

    /**
     * Get from Url.
     * 
     * @param object $object Entity object
     * 
     * @return string
     */
    protected function getShortUrlFromObject($object)
    {
        if ($link = $this->getLinkEntityFromObject($object)) {
            return $link->getShortUrl();
        } else {
            if ($newShortLink = $this->createNewLink($object)) {
                return $newShortLink->getShortUrl();
            }
        }

        return null;
    }

    /**
     * Get short URL from long one.
     * 
     * @param string $longUrl Long URL
     * 
     * @return string
     */
    protected function getShortUrlFromLongUrl($longUrl)
    {
        if ($link = $this->getLinkEntityFromLongUrl($longUrl)) {
            return $link->getShortUrl();
        }

        return null;
    }

    /**
     * Get short URL from hash.
     * 
     * @param string $hash Hash
     * 
     * @return string
     */
    protected function getShortUrlFromHash($hash)
    {
        if ($link = $this->getLinkEntityFromHash($hash)) {
            return $link->getShortUrl();
        }

        return null;
    }

    /**
     * Get repository from entity manager.
     * 
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository('SlyUrlShortenerBundle:Link');
    }
}