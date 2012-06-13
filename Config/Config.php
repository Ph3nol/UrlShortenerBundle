<?php

namespace Sly\UrlShortenerBundle\Config;

use Sly\UrlShortenerBundle\Model\EntityCollection;

/**
 * Config.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Config implements ConfigInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getEntryCollectionFromConfig(array $config)
    {
        $configEntities = new EntityCollection();

        foreach ($config['entities'] as $name => $data) {
            $configEntities->set($name, $data);
        }

        return $configEntities;
    }
}
