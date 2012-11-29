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
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('longUrlIfException')->defaultFalse()->end()
                    ->scalarNode('provider')->defaultValue('googl')->cannotBeEmpty()->end()
                    ->scalarNode('domain')->defaultValue(null)->end()
                    ->arrayNode('api')
                        ->children()
                            ->scalarNode('username')->defaultValue(null)->end()
                            ->scalarNode('key')->defaultValue(null)->end()
                        ->end()
                    ->end()
                    ->arrayNode('entities')
                        ->useAttributeAsKey('entityName')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('provider')->defaultValue('googl')->cannotBeEmpty()->end()
                                ->scalarNode('route')->cannotBeEmpty()->end()
                                ->scalarNode('domain')->defaultValue(null)->end()
                                ->arrayNode('api')
                                    ->children()
                                        ->scalarNode('username')->defaultValue(null)->end()
                                        ->scalarNode('key')->defaultValue(null)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
