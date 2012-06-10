<?php

namespace Sly\UrlShortenerBundle\Shortener;

use Sly\UrlShortenerBundle\Entity\Link;
use Sly\UrlShortenerBundle\Provider\ProviderInterface;
use Sly\UrlShortenerBundle\Provider\Internal,
    Sly\UrlShortenerBundle\Provider\Bitly,
    Sly\UrlShortenerBundle\Provider\Googl;

/**
 * Shortener service.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Shortener implements ShortenerInterface
{
    /**
     * @var ProviderInterface $provider
     */
    protected $provider;

    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * Set Provider instance.
     * 
     * @param string $provider        Provider name
     * @param array  $providerApiData Provider API data from project configuration file
     */
    public function setProvider($provider, array $providerApiData = array())
    {
        $shortUrlProviderClass = ucfirst($provider);

        switch ($provider)
        {
            default:
            case 'internal':
                $this->provider = new Internal();

                break;

            case 'bitly':
                $this->provider = new Bitly($providerApiData);

                break;

            case 'googl':
                $this->provider = new Googl($providerApiData);

                break;
        }
    }

    /**
     * Create short URL.
     * 
     * @param string $longUrl Long URL
     * 
     * @return string
     */
    public function createShortUrl($longUrl)
    {
        $this->provider->setLongUrl($longUrl);

        return $this->provider->create();
    }
}