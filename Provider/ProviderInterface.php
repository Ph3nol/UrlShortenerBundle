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
     * @return string Generated hash
     */
    public function generate();
}