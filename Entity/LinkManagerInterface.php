<?php

namespace Sly\UrlShortenerBundle\Entity;

/**
 * LinkManager interface.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface LinkManagerInterface
{
    /**
     * @return ObjectManager
     */
    public function getEntityManager();
}