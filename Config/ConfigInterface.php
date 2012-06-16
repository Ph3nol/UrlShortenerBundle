<?php

namespace Sly\UrlShortenerBundle\Config;

use Sly\UrlShortenerBundle\Model\EntityCollection;

/**
 * Config interface.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface ConfigInterface
{
    /**
     * Get entity from collection.
     * 
     * @param string $entityName Entity name
     */
    public function getEntity($entityName);

    /**
     * Get entities collection.
     * 
     * @return EntityCollection
     */
    public function getEntities();
}