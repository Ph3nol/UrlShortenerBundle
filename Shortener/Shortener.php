<?php

namespace Sly\UrlShortenerBundle\Shortener;

use Sly\UrlShortenerBundle\Model\LinkManagerInterface;
use Sly\UrlShortenerBundle\Provider\ProviderManager;
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
     * @var LinkManagerInterface
     */
    protected $linkManager;

    /**
     * @var ProviderInterface $provider
     */
    protected $provider;

    /**
     * Constructor.
     * 
     * @param LinkManagerInterface $linkManager     Link Manager service
     * @param ProviderManager      $providerManager Provider Manager service
     */
    public function __construct(LinkManagerInterface $linkManager, ProviderManager $providerManager)
    {
        $this->linkManager     = $linkManager;
        $this->providerManager = $providerManager;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(array $config)
    {
        $this->provider = $this->providerManager->getProvider($config['provider']);
        $this->provider->setConfig($config);
    }

    /**
     * {@inheritdoc}
     */
    public function shorten($longUrl)
    {
        return $this->provider->shorten($longUrl);
    }

    /**
     * {@inheritdoc}
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
