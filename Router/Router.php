<?php

namespace Sly\UrlShortenerBundle\Router;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Bundle\FrameworkBundle\Routing\Router as BaseRouter;

/**
 * Router service.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Router implements RouterInterface
{
    /**
     * @var BaseRouter
     */
    protected $baseRouter;

    /**
     * @var array
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param BaseRouter $baseRouter Bundle Router service
     * @param array      $config     Bundle configuration
     */
    public function __construct(BaseRouter $baseRouter, array $config)
    {
        $this->baseRouter = $baseRouter;
        $this->config     = $config;
    }

    /**
     * Get object show route.
     *
     * @param object $object        Object
     * @param string $showRouteName Show route name
     *
     * @return string
     */
    public function getObjectShowRoute($object, $showRouteName)
    {
        $objectEntityClass  = get_class($object);

        $routes = $this->baseRouter->getRouteCollection();
        $route  = $routes->get($showRouteName);

        preg_match_all('/{(\w*)}/', $route->getPattern(), $matches);

        foreach ($matches[1] as $e) {
            $eAccessor = sprintf('get%s', ucfirst(Container::camelize($e)));

            if (method_exists($objectEntityClass, $eAccessor)) {
                $routeElements[$e] = $object->$eAccessor();
            }
        }

        return $this->baseRouter->generate($showRouteName, $routeElements, true);
    }
}
