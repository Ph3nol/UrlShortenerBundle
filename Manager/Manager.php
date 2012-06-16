<?php

namespace Sly\UrlShortenerBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sly\UrlShortenerBundle\Config\ConfigInterface;
use Sly\UrlShortenerBundle\Shortener\Shortener;
use Sly\UrlShortenerBundle\Shortener\ShortenerInterface;
use Sly\UrlShortenerBundle\Router\Router;
use Sly\UrlShortenerBundle\Router\RouterInterface;
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
     * @param EntityManager      $em             Entity Manager service
     * @param ShortenerInterface $shortener      Shortener service
     * @param RouterInterface    $router         Bundle Router service
     * @param ConfigInterface    $config         Configuration service
     */
    public function __construct(EntityManager $em, ShortenerInterface $shortener, RouterInterface $router, ConfigInterface $config)
    {
        $this->em        = $em;
        $this->shortener = $shortener;
        $this->router    = $router;
        $this->config    = $config;

        // $this->config['internalCount'] = $this->getInternalLinksCount();
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkEntityFromObject($object)
    {
        $objectEntityClass = get_class($object);

        if (false === $this->config->getEntities()->has($objectEntityClass)) {
            throw new \Exception(sprintf('There is no "%s" entity in UrlShortener bundle configuration', $objectEntityClass));
        }

        $q = $this->getRepository()
            ->createQueryBuilder('l')
            ->where('l.objectEntity = :objectEntity')
            ->andWhere('l.objectId = :objectId')
            ->setParameters(array(
                'objectEntity' => $objectEntityClass,
                'objectId'     => $object->getId(),
            ));

        return $q->getQuery()->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getInternalLinksCount()
    {
        $q = $this->getRepository()
            ->createQueryBuilder('l')
            ->select('COUNT(l)')
            ->where('l.provider = :internalProvider')
            ->setParameter('internalProvider', 'internal');

        return $q->getQuery()->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function createNewLinkFromObject($object)
    {
        $objectEntityName = get_class($object);
        $this->config     = $this->config->getEntity($objectEntityName);

        $this->shortener->setProvider($this->config);

        $longUrl = $this->router->getObjectShowRoute($object, $this->config['route']);

        if ($link = $this->getNewLinkEntity($longUrl)) {
            $link->setObjectEntity($objectEntityName);
            $link->setObjectId($object->getId());

            $this->em->persist($link);
            $this->em->flush($link);

            return $link;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function createNewLinkFromUrl($longUrl)
    {
        $this->shortener->setProvider($this->config);

        if ($link = $this->getNewLinkEntity($longUrl)) {
            $this->em->persist($link);
            $this->em->flush($link);

            return $link;
        }

        return false;
    }

    /**
     * Get new Link entity.
     *
     * @param string $longUrl Long URL
     *
     * @return Link
     */
    protected function getNewLinkEntity($longUrl)
    {
        if ($createdShortUrl = $this->shortener->createShortUrl($longUrl)) {
            $link = new Link();
            $link->setShortUrl($createdShortUrl['shortUrl']);
            $link->setLongUrl($longUrl);
            $link->setHash($createdShortUrl['hash']);
            $link->setProvider($this->config['provider']);

            return $link;
        }

        return false;
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
        if ($link = $this->getLinkEntityFromLongUrl($longUrl)) {
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
        if ($link = $this->getLinkEntityFromHash($hash)) {
            return $link->getShortUrl();
        }
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
