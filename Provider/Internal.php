<?php

namespace Sly\UrlShortenerBundle\Provider;

use Sly\UrlShortenerBundle\Model\LinkInterface;
use Sly\UrlShortenerBundle\Provider;

/**
 * Internal provider.
 *
 * @uses BaseProvider
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Internal extends BaseProvider implements ProviderInterface
{
    /**
     * @var LinkInterface $lastLink
     */
    protected $lastLink = null;

    /**
     * Set last Link.
     * 
     * @param LinkInterface $lastLink Link
     */
    public function setLastLink(LinkInterface $lastLink)
    {
        $this->lastLink = $lastLink;
    }

    /**
     * Create short URL.
     * 
     * @return array
     */
    public function shorten()
    {
        parent::shorten();

        $lastLinkHash = $this->lastLink ? $this->lastLink->getHash() : null;

        /**
         * @todo
         */

        return array(
            'hash'     => '',
            'shortUrl' => '',
        );
    }
}