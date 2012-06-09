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
     * @return string Generated hash
     */
    public static function generate($longUrl);
}