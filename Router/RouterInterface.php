<?php

namespace Sly\UrlShortenerBundle\Router;

/**
 * Router service.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface RouterInterface
{
    /**
     * @param object $object Object
     * 
     * @return string
     */
    public function getObjectShowRoute($object);
}