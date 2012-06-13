<?php

namespace Sly\UrlShortenerBundle\Provider\Internal;

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
    /**
     * Create short URL.
     * 
     * @return array
     */
    public function shorten()
    {
        parent::shorten();

        if (!$this->config['domain']) {
            throw new \InvalidArgumentException('Internal Provider must have a domain to generate short URLs');
        }

        $newLinkHash = Shortener::getHashFromBit($this->config['internalCount'] + 1);

        return array(
            'hash'     => $newLinkHash,
            'shortUrl' => sprintf('http://%s/%s', $this->config['domain'], $newLinkHash),
        );
    }
}