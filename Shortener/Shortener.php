<?php

namespace Sly\UrlShortenerBundle\Shortener;

use Sly\UrlShortenerBundle\Entity\Link;
use Sly\UrlShortenerBundle\Provider\ProviderInterface;
use Sly\UrlShortenerBundle\Provider\Internal\Internal,
    Sly\UrlShortenerBundle\Provider\External\Bitly,
    Sly\UrlShortenerBundle\Provider\External\Googl;

/**
 * Shortener service.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Shortener implements ShortenerInterface
{
    /**
     * @var integer $providerParams
     */
    protected $providerParams;

    /**
     * @var ProviderInterface $provider
     */
    protected $provider;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->providerParams = array();
    }

    /**
     * Set Provider params.
     * 
     * @param array $providerParams Provider parameters
     */
    public function setProviderParams(array $providerParams = array())
    {
        $this->providerParams = $providerParams;
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
                $this->provider = new Internal(array(), $this->providerParams);

                break;

            case 'bitly':
                $this->provider = new Bitly($providerApiData);

                break;

            case 'googl':
                $this->provider = new Googl();

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

        return $this->provider->shorten();
    }

    /**
     * Get hash from bit.
     * The trick is to create your own base system with a custom set of characters.
     * 
     * @param integer $bitNumber Bit number
     * 
     * @return string
     */
    public static function getHashFromBit($bitNumber = 1)
    {
        $codeSet   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base      = strlen($codeSet);
        $converted = '';

        while ($bitNumber > 0) {
          $converted = substr($codeSet, ($bitNumber % $base), 1).$converted;
          $bitNumber = floor($bitNumber / $base);
        }

        return $converted;
    }
}