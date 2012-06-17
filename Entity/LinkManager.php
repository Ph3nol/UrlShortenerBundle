<?php

namespace Sly\UrlShortenerBundle\Entity;

use Doctrine\ORM\EntityManager;
use Sly\UrlShortenerBundle\Model\LinkInterface;
use Sly\UrlShortenerBundle\Model\LinkManagerInterface;
use Sly\UrlShortenerBundle\Provider\Internal\Internal;

/**
 * LinkManager interface.
 *
 * @uses LinkManagerInterface
 * @author Cédric Dugat <ph3@slynett.com>
 */
class LinkManager implements LinkManagerInterface
{
    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @param EntityManager $em         Entity manager service
     * @param string        $repository Repository name
     */
    public function __construct(EntityManager $em, $repository)
    {
        $this->em         = $em;
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getOneFromObject($object)
    {
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
     * {@inheritdoc}
     */
    public function getOneFromLongUrl($longUrl)
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
    public function getOneFromHash($hash)
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
    public function getOneInternalFromHash($hash)
    {
        $q = $this->getRepository()
            ->createQueryBuilder('l')
            ->where('l.hash = :hash')
            ->andWhere('l.provider = :provider')
            ->setParameters(array(
                'hash' => $hash,
                'provider' => Internal::PROVIDER_NAME,
            ));

        return $q->getQuery()->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getInternalCount()
    {
        $q = $this->getRepository()
            ->createQueryBuilder('l')
            ->select('COUNT(l)')
            ->where('l.provider = :internalProvider')
            ->setParameter('internalProvider', Internal::PROVIDER_NAME);

        return $q->getQuery()->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
     public function create(array $config, array $shortenerData, $object = null)
     {
        $link = new Link();
        $link->setShortUrl($shortenerData['shortUrl']);
        $link->setLongUrl($shortenerData['longUrl']);
        $link->setHash($shortenerData['hash']);
        $link->setProvider($config['provider']);

        if ($object && is_object($object)) {
            $link->setObjectEntity(get_class($object));
            $link->setObjectId($object->getId());
        }

        $this->getEntityManager()->persist($link);
        $this->getEntityManager()->flush($link);

        return $link;
     }

    /**
     * Get entity manager.
     *
     * @return ObjectManager
     */
    protected function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Get repository.
     *
     * @return object
     */
    protected function getRepository()
    {
        return $this->getEntityManager()->getRepository($this->repository);
    }
}
