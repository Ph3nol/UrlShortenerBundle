<?php

namespace Sly\UrlShortenerBundle\Twig\Extension;

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
     * @var ManagerInterface
     */
    protected $manager;

    /**
     * Constructor.
     *
     * @param \Twig_Environment $twig    Twig service
     * @param ManagerInterface  $manager Manager service
     */
    public function __construct(\Twig_Environment $twig, ManagerInterface $manager)
    {
        $this->twig    = $twig;
        $this->manager = $manager;
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
        return $this->manager->getShortUrl($item);
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
