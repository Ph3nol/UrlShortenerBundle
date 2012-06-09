<?php

namespace Sly\UrlShortenerBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sly\UrlShortenerBundle\Router\Router;
use Sly\Sly\UrlShortenerBundle\Entity\Link;

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
     * @var Router
     */
    protected $router;

    /**
     * @var array
     */
    protected $config;

    /**
     * Constructor.
     * 
     * @param EntityManager $em     Entity Manager service
     * @param Router        $router Bundle Router service
     * @param array         $config Bundle configuration
     */
    public function __construct(EntityManager $em, Router $router, array $config)
    {
        $this->em     = $em;
        $this->router = $router;
        $this->config = $config;
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
        $itemEntityClass = get_class($object);

        if (false === in_array($itemEntityClass, array_keys($this->config['entities']))) {
            throw new \Exception(sprintf('There is no "%s" entity in UrlShortener bundle configuration', $itemEntityClass));
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
     * Get long URL from hash.
     * 
     * @param string $hash Hash
     * 
     * @return Link
     */
    public function getLongUrlFromHash($hash)
    {
        $q = $this->getRepository()
                ->createQueryBuilder('l')
                ->where('l.hash = :hash')
                ->setParameter('hash', $hash);

        return $q->getQuery()->getOneOrNullResult();
    }

    /**
     * Get long URL from short URL.
     * 
     * @param string $shortUrl Short URL
     * 
     * @return Link
     */
    public function getLongUrlFromShortUrl($shortUrl)
    {
        $q = $this->getRepository()
                ->createQueryBuilder('l')
                ->where('l.shortUrl = :shortUrl')
                ->setParameter('shortUrl', $shortUrl);

        return $q->getQuery()->getOneOrNullResult();
    }

    /**
     * Get hash from URL.
     * 
     * @param string $url Long URL
     * 
     * @return Link
     */
    public function getHashFromLongUrl($url)
    {
        $q = $this->getRepository()
                ->createQueryBuilder('l')
                ->where('l.longUrl = :longUrl')
                ->setParameter('longUrl', $url);

        return $q->getQuery()->getOneOrNullResult();
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
        /**
         * @todo
         */
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