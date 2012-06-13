<?php

namespace Sly\UrlShortenerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 *
 * @uses ConfigurationInterface
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder
            ->root('sly_url_shortener')
            ->children()
                ->scalarNode('provider')->defaultValue('googl')->end()
                ->scalarNode('domain')->defaultValue(null)->end()
                ->scalarNode('api_username')->defaultValue(null)->end()
                ->scalarNode('api_key')->defaultValue(null)->end()
                ->variableNode('entities')->defaultValue(array())
                ->end()
            ->end();

        return $treeBuilder;
    }
}
