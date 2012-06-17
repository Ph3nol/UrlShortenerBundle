<?php

namespace Sly\UrlShortenerBundle\Config;

use Sly\UrlShortenerBundle\Model\EntityCollection;
use Sly\UrlShortenerBundle\Provider\Internal\Internal;

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

        $this->checkConfiguration();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        unset($this->config['entities']);

        return $this->config;
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

    /**
     * Check configuration.
     * Some logical and requires checks.
     */
    protected function checkConfiguration()
    {
        $configConfig = $this->getConfig();

        if ($configConfig['provider'] == Internal::PROVIDER_NAME && empty($configConfig['domain'])) {
            throw new \InvalidArgumentException('Your main config provider is Internal one and must have a domain setted');
        }

        foreach ($this->getEntities() as $name => $data) {
            if ($data['provider'] == Internal::PROVIDER_NAME && empty($data['domain'])) {
                throw new \InvalidArgumentException(sprintf('%s entity\'s provider is Internal and must have a domain setted', $name));
            }
        }
    }
}