<?php

namespace Sly\UrlShortenerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * AddProviders.
 *
 * @uses CompilerPassInterface
 * @author Cédric Dugat <ph3@slynett.com>
 */
class AddProviders implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('sly_url_shortener.provider') as $id => $tag) {
            $tag = array_pop($tag);

            if (!isset($tag['key'])) {
                throw new \Exception('You should define a key for all "sly_url_shortener.provider" tagged services');
            }

            $container->getDefinition('sly_url_shortener.provider_manager')
                ->addMethodCall('addProvider', array($tag['key'], $container->getDefinition($id)));
        }
    }
}
