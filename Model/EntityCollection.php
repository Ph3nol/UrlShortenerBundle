<?php

namespace Sly\UrlShortenerBundle\Model;

/**
 * Entity collection.
 * Entities setted from project configuration file are collected
 * through this collection.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
class EntityCollection implements \IteratorAggregate
{
    protected $coll;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->coll = new \ArrayIterator();
    }

    /**
     * @return array
     */
    public function getIterator()
    {
        return $this->coll;
    }

    /**
     * Set method.
     *
     * @param string $entity Entity
     * @param array  $data   Data
     */
    public function set($entity, array $data = array())
    {
        $this->coll[$entity] = $data;
    }

    /**
     * Has method.
     *
     * @param string $entity Entity
     * 
     * @return boolean
     */
    public function has($entity)
    {
        return $this->coll->offsetExists($entity);
    }

    /**
     * Get entities.
     * 
     * @return \ArrayIterator
     */
    public function getEntities()
    {
        return $this->coll;
    }
}