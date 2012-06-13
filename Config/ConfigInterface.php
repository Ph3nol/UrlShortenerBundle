<?php

namespace Sly\UrlShortenerBundle\Config;

/**
 * Config interface.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface ConfigInterface
{
    /**
     * Get EntryCollection from configuration.
     *
     * @param array $config Configuration
     *
     * @return EntryCollection
     */
    public static function getEntryCollectionFromConfig(array $config);
}
