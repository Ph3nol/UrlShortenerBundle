<?php

namespace Sly\UrlShortenerBundle\Provider\Internal;

use Sly\UrlShortenerBundle\Model\LinkManagerInterface;
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
     * @param LinkManagerInterface $linkManager LinkManager service
     */
    public function __construct(LinkManagerInterface $linkManager)
    {
        parent::__construct();

        $this->internalLinksCount = $linkManager->getInternalCount();
    }

    /**
     * {@inheritdoc}
     */
    public function shorten($longUrl)
    {
        if (!$this->config['domain']) {
            throw new \InvalidArgumentException('Internal Provider must have a domain to generate short URLs');
        }

        $newLinkHash = Shortener::getHashFromBit($this->internalLinksCount + 1);

        return array(
            'provider' => self::PROVIDER_NAME,
            'hash'     => $newLinkHash,
            'shortUrl' => sprintf('http://%s/%s', $this->config['domain'], $newLinkHash),
            'longUrl'  => $longUrl,
        );
    }
}
