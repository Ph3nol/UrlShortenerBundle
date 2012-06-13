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
     * @param array $config Configuration
     * 
     * @return EntryCollection
     */
    public static function getEntryCollectionFromConfig(array $config);
}