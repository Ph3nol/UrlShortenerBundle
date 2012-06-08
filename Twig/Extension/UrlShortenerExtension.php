<?php

namespace Sly\UrlShortenerBundle\Twig\Extension;

use Sly\UrlShortenerBundle\Entity\Link;
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
            'render_longurl' => new \Twig_Function_Method($this, 'renderLongUrlFromHash'),
        );
    }

    /**
     * Render long URL from hash.
     * 
     * @param string $hash Hash
     *
     * @return string
     */
    public function renderLongUrlFromHash($hash)
    {
        return $this->manager->getLongUrlFromHash($hash);
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