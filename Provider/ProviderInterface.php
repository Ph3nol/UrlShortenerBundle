<?php

namespace Sly\UrlShortenerBundle\Provider;

/**
 * Provider interface.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface ProviderInterface
{
    /**
     * @param string $longUrl Long URL
	 *
     * @return array Generated short URL informations
     */
    public function shorten($longUrl);
}
