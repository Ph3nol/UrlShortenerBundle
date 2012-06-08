<?php

namespace Sly\UrlShortenerBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

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
     * Constructor.
     * 
     * @param EntityManager $em Entity Manager service
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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
                ->where('l.url = :url')
                ->setParameter('url', $url);

        return $q->getQuery()->getOneOrNullResult();
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