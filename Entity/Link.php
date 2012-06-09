<?php

namespace Sly\UrlShortenerBundle\Entity;

use Sly\UrlShortenerBundle\Model\Link as BaseLink;

/**
 * Link Doctrine entity.
 *
 * @uses BaseLink
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Link extends BaseLink
{
    /**
     * __toString.
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getShortUrl();
    }
}