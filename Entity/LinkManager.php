<?php

namespace Sly\UrlShortenerBundle\Entity;

use Sly\UrlShortenerBundle\Model\LinkInterface;
use Sly\UrlShortenerBundle\Entity\LinkManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;

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
     * @var string
     */
    protected $link;

    /**
     * @param ObjectManager $em   Entity manager service
     * @param LinkInterface $link Link model
     */
    public function __construct(ObjectManager $em, LinkInterface $link)
    {
        $this->em = $em;
        $this->link = $link;
    }

    /**
     * Get entity manager.
     *
     * @return ObjectManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }
}
