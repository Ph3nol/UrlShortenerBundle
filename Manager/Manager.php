<?php

namespace Sly\UrlShortenerBundle\Manager;

use Doctrine\ORM\EntityManager;

/**
 * Manager service.
 *
 * @uses BaseManager
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Manager implements ManagerInterface extends BaseManager
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
     * Get repository from entity manager.
     * 
     * @return Link
     */
    protected function getRepository()
    {
        return $this->em->getRepository('SlyUrlShortenerBundle:Link');
    }
}