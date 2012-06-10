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
     * Set long URL.
     * 
     * @param string $longUrl Long URL
     */
    public function setLongUrl($longUrl);

    /**
     * @return object Generated short URL informations
     */
    public function create();
}