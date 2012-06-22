SlyUrlShortenerBundle
====================

You easily can add a new Provider as a tagged service. To do this,
just check out the two following steps.

## 1. Create your Provider class

You class must implement `Sly\UrlShortBundle\Provider\ProviderInterface` interface
and extend `Sly\UrlShortBundle\Provider\BaseProvider`. Here is an example:

```php
<?php

namespace Acme\DemoBundle\Provider\MyProvider;

use Sly\UrlShortenerBundle\Provider\BaseProvider;
use Sly\UrlShortenerBundle\Provider\ProviderInterface;

/**
 * My Provider class.
 *
 * @uses BaseProvider
 * @author Cédric Dugat <ph3@slynett.com>
 */
class MyProvider extends BaseProvider implements ProviderInterface
{
    CONST PROVIDER_NAME = 'myprovider';
    CONST API_URL       = 'https://service.api.url.com';

    /**
     * {@inheritdoc}
     */
    public function shorten($longUrl)
    {
        /**
         * Your logic here, using $longUrl long URL.
         * You must return a data array with 4 informations (2 from Provider itself).
         */
        return array(
            'provider' => self::PROVIDER_NAME,
            'longUrl'  => $longUrl,
            'hash'     => /* --- The generated hash */,
            'shortUrl' => /* --- The short URL */,
        );
    }
}

```