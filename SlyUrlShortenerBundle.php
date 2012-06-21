<?php

namespace Sly\UrlShortenerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Sly\UrlShortenerBundle\DependencyInjection\Compiler\AddProviders;

/**
 * SlyUrlShortenerBundle.
 *
 * @uses Bundle
 * @author Cédric Dugat <ph3@slynett.com>
 */
class SlyUrlShortenerBundle extends Bundle
{
    /**
     * Build method.
     * 
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddProviders());
    }
}
