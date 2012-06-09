<?php

namespace Sly\UrlShortenerBundle\Twig\Extension;

use Symfony\Component\Routing\Route;
use Sly\UrlShortenerBundle\Entity\Link;
use Sly\UrlShortenerBundle\Router\Router;
use Sly\UrlShortenerBundle\Manager\Manager;
use Sly\UrlShortenerBundle\Manager\ManagerInterface;

/**
 * UrlShortener Twig extension.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
class UrlShortenerExtension extends \Twig_Extension
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var ManagerInterface
     */
    protected $manager;

    /**
     * @var array
     */
    protected $config;

    /**
     * Constructor.
     * 
     * @param \Twig_Environment $twig    Twig service
     * @param Router            $router  Bundle Router service
     * @param ManagerInterface  $manager Manager service
     * @param array             $config  Bundle configuration
     */
    public function __construct(\Twig_Environment $twig, Router $router, ManagerInterface $manager, array $config)
    {
        $this->twig    = $twig;
        $this->router  = $router;
        $this->manager = $manager;
        $this->config  = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'render_short_url' => new \Twig_Function_Method($this, 'renderShortUrl'),
        );
    }

    /**
     * Render short URL.
     * 
     * @param mixed $item Item (hash, URL or object)
     * 
     * @return string
     */
    public function renderShortUrl($item)
    {
        if (is_object($item)) {
            $itemEntityClass = get_class($item);

            if (false === in_array($itemEntityClass, array_keys($this->config['entities']))) {
                throw new \Exception(sprintf('There is no "%s" entity in UrlShortener bundle configuration', $itemEntityClass));
            }

            if ($link = $this->manager->getLinkEntityFromObject($item)) {
                return $link->getShortUrl();
            }

            /**
             * @todo URL to short: $this->router->getObjectShowRoute($item)
             */
        } else {
            /**
             * @todo
             */
        }
    }

    /**
     * Returns extension name.
     *
     * @return string
     */
    public function getName()
    {
        return 'sly_url_shortener_extension';
    }
}