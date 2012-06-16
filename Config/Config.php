<?php

namespace Sly\UrlShortenerBundle\Config;

use Sly\UrlShortenerBundle\Model\EntityCollection;

/**
 * Config.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Config implements ConfigInterface
{
    /**
     * @var $config array
     */
    protected $config;

    /**
     * @var $entities EntityCollection
     */
    protected $entities;

    /**
     * Constructor.
     * 
     * @param array $config Configuration
     */
    public function __construct(array $config)
    {
        $this->config   = $config;
        $this->entities = new EntityCollection();

        foreach ($this->config['entities'] as $name => $data) {
            $this->entities->set($name, $data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity($entityName)
    {
        return $this->entities->get($entityName);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntities()
    {
        return $this->entities;
    }
}