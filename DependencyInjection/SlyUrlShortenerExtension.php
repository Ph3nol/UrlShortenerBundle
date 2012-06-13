<?php

namespace Sly\UrlShortenerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
class SlyUrlShortenerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('manager.xml');
        $loader->load('shortener.xml');
        $loader->load('router.xml');
        $loader->load('twig.xml');

        // Configuration management and overloads

        $configuration = $configs[0];

        foreach ($configuration['entities'] as $entityName => $entityParams) {
            foreach (array('provider', 'domain', 'api_username', 'api_key') as $param) {
                if (empty($configuration['entities'][$entityName][$param])) {
                    $configuration['entities'][$entityName][$param] = isset($configuration[$param]) ? $configuration[$param] : null;
                }
            }
        }

        $container->setParameter('sly_url_shortener.config', $configuration);
    }
}
