<?php

namespace Sly\UrlShortenerBundle\Twig\Extension;

use Sly\UrlShortenerBundle\Entity\Link;

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
    private $twig;

    /**
     * @param \Twig_Environment $twig Twig service
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'shorturl_render' => new \Twig_Function_Method($this, 'renderShortUrl'),
        );
    }

    /**
     * @param Link $link Link object
     *
     * @return string
     */
    public function renderShortUrl(Link $link)
    {
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