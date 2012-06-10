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
            return $this->getShortUrlFromObject($item);
        } else {
            if (preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $item)) {
                return $this->getShortUrlFromLongUrl($item);
            } else {
                return $this->getShortUrlFromHash($item);
            }
        }
    }

    /**
     * Get from Url.
     * 
     * @param object $object Entity object
     * 
     * @return string
     */
    protected function getShortUrlFromObject($object)
    {
        if ($link = $this->manager->getLinkEntityFromObject($object)) {
            return $link->getShortUrl();
        } else {
            if ($newShortLink = $this->manager->createNewLink($object)) {
                return $newShortLink->getShortUrl();
            }
        }

        return null;
    }

    /**
     * Get short URL from long one.
     * 
     * @param string $longUrl Long URL
     * 
     * @return string
     */
    protected function getShortUrlFromLongUrl($longUrl)
    {
        if ($link = $this->manager->getLinkEntityFromLongUrl($longUrl)) {
            return $link->getShortUrl();
        }

        return null;
    }

    /**
     * Get short URL from hash.
     * 
     * @param string $hash Hash
     * 
     * @return string
     */
    protected function getShortUrlFromHash($hash)
    {
        if ($link = $this->manager->getLinkEntityFromHash($hash)) {
            return $link->getShortUrl();
        }

        return null;
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