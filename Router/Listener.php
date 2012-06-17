<?php

namespace Sly\UrlShortenerBundle\Router;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Router as BaseRouter;
use Sly\UrlShortenerBundle\Config\ConfigInterface;
use Sly\UrlShortenerBundle\Model\LinkManagerInterface;

/**
 * Router listener for internal Provider.
 */
class Listener
{
    /**
     * @var Kernel $kernel
     */
    protected $kernel;

    /**
     * @var BaseRouter $router
     */
    protected $router;

    /**
     * @var LinkManagerInterface
     */
    protected $linkManager;

    /**
     * Constructor.
     *
     * @param Kernel          $kernel      Kernel service
     * @param BaseRouter      $router      Router service
     * @param LinkManager     $linkManager Link Manager service
     * @param ConfigInterface $config      Configuration service
     */
    public function __construct(Kernel $kernel, BaseRouter $router, LinkManagerInterface $linkManager, ConfigInterface $config)
    {
        $this->kernel      = $kernel;
        $this->router      = $router;
        $this->linkManager = $linkManager;
        $this->config      = $config;
    }

    /**
     * onDomainParse.
     *
     * @param Event $event Event object
     */
    public function onDomainParse(Event $event)
    {
        $request = $event->getRequest();
        $session = $request->getSession();

        $shortUrlData = $this->isShortUrl($request->getUri());

        if ($shortUrlData && ($link = $this->linkManager->getOneInternalFromHash($shortUrlData[2]))) {
            $event->setResponse(new RedirectResponse($link->getLongUrl()), 301);
        }
    }

    /**
     * Is short URL.
     * 
     * @param string $url URL
     * 
     * @return boolean
     */
    protected function isShortUrl($url)
    {
        $url = str_replace(
            array('http://www.', 'http://'),
            array(),
            $url
        );

        if (preg_match('/^([a-zA-Z0-9-]*.[a-zA-Z0-9]{2,4})\/([a-zA-Z0-9]{1,10})$/', $url, $matches)) {
            return $matches;
        }

        return false;
    }
}
