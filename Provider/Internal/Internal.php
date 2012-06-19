<?php

namespace Sly\UrlShortenerBundle\Provider\Internal;

use Sly\UrlShortenerBundle\Model\LinkManager;
use Sly\UrlShortenerBundle\Provider\BaseProvider;
use Sly\UrlShortenerBundle\Provider\ProviderInterface;
use Sly\UrlShortenerBundle\Shortener\Shortener;

/**
 * Internal provider.
 *
 * @uses BaseProvider
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Internal extends BaseProvider implements ProviderInterface
{
    CONST PROVIDER_NAME = 'internal';

    /**
     * @var integer
     */
    protected $internalLinksCount;

    /**
     * Constructor.
     * 
     * @param integer $linkManager LinkManager service
     * @param array   $config      Configuration
     */
    public function __construct(LinkManager $linkManager, array $config = array())
    {
        parent::__construct($config);

        $this->internalLinksCount = $linkManager->getInternalCount();
    }

    /**
     * Create short URL in internal.
     * {@inheritdoc}
     */
    public function shorten($longUrl)
    {
        if (!$this->config['domain']) {
            throw new \InvalidArgumentException('Internal Provider must have a domain to generate short URLs');
        }

        $newLinkHash = Shortener::getHashFromBit($this->internalLinksCount + 1);

        return array(
            'hash'     => $newLinkHash,
            'shortUrl' => sprintf('http://%s/%s', $this->config['domain'], $newLinkHash),
            'longUrl'  => $longUrl,
        );
    }
}
