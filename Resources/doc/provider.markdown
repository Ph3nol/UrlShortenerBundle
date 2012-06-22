SlyUrlShortenerBundle
====================

You easily can add a new provider as a tagged service. To do this,
just check out the two following steps.

## 1. Create your provider class

You class must implement `Sly\UrlShortBundle\Provider\ProviderInterface` interface
and extend `Sly\UrlShortBundle\Provider\BaseProvider`. Here is an example:

```php
<?php
// Acme\DemoBundle\Provider\MyProvider.php

namespace Acme\DemoBundle\Provider;

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
    CONST API_URL       = 'https://api.your-short-url-service.com';

    /**
     * {@inheritdoc}
     */
    public function shorten($longUrl)
    {
        /**
         * Your Provider logic here, using $longUrl long URL.
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
## 2. Add your service to DiC

Now you just have to
[add your provider service](http://symfony.com/doc/current/book/service_container.html#creating-configuring-services-in-the-container)
to your DiC. You must [tag it](http://symfony.com/doc/current/book/service_container.html#tags-tags) with `sly_url_shortener.provider`
and declare a key (for example `myprovider`) which can be associated to your provider `PROVIDER_NAME` class constant.

Here is a `Acme\DemoBundle\Resources\config\myprovider.xml` example:

```xml
<?xml version="1.0" ?>

<container xmlns="http://symfony.com/schema/dic/services"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">

    <parameters>
        <parameter key="acme.url_shortener.provider_my_provider.class">Acme\DemoBundle\Provider\MyProvider</parameter>
    </parameters>

    <services>
        <service id="acme.url_shortener.provider_my_provider" class="%acme.url_shortener.provider_my_provider.class%">
            <tag name="sly_url_shortener.provider" key="myprovider"></tag>
            <!-- Your facultative <argument /> entries -->
        </service>
    </services>

</container>
```

## 3. Just load your provider service from your DiC configuration

```php
<?php
// Acme\DemoBundle\DependencyInjection\Configuration.php
    // ...
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        // ...
        $loader->load('myprovider.xml');
    // ...
```