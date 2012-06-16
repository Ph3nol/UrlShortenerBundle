<?php

namespace Sly\UrlShortenerBundle\Shortener;

use Sly\UrlShortenerBundle\Model\LinkManagerInterface;
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
     * @param LinkManagerInterface $linkManager Link Manager service
     */
    public function __construct(LinkManagerInterface $linkManager)
    {
        $this->linkManager = $linkManager;
    }

    /**
     * {@inheritdoc}
     */
    public function setProvider(array $config)
    {
        switch ($config['provider']) {
            default:
            case 'internal':
                $this->provider = new Internal($config, $this->linkManager->getInternalCount());

                break;

            case 'bitly':
                $this->provider = new Bitly($config);

                break;

            case 'googl':
                $this->provider = new Googl();

                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function createShortUrl($longUrl)
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
