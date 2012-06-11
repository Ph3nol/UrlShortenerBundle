<?php

namespace Sly\UrlShortenerBundle\Provider;

use Sly\UrlShortenerBundle\Provider;
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

        if (!$this->params['domain']) {
            throw new \InvalidArgumentException('Internal Provider must have a domain to generate short URLs');
        }

        $newLinkHash = Shortener::getHashFromBit($this->params['internalLinksCount']++);

        return array(
            'hash'     => $newLinkHash,
            'shortUrl' => sprintf('http://%s/%s', $this->params['domain'], $newLinkHash),
        );
    }
}