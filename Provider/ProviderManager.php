<?php

namespace Sly\UrlShortenerBundle\Provider;
use Sly\UrlShortenerBundle\Provider\ProviderInterface;

/**
 * ProviderManager.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
class ProviderManager
{
    protected $providers = array();

    /**
     * Add a Provider.
     *
     * @param string            $name     Name
     * @param ProviderInterface $provider Provider
     */
    public function addProvider($name, ProviderInterface $provider)
    {
        $this->providers[$name] = $provider;
    }

    /**
     * Get Provider.
     * 
     * @param string $name Name
     * 
     * @return ProviderInterface|null
     */
    public function getProvider($name)
    {
        return isset($this->providers[$name]) ? $this->providers[$name] : null;
    }
}
