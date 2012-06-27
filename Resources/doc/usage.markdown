SlyUrlShortenerBundle
====================

# Usage

## 1. Configuration bundle informations

You have to define all Links/Entities relations from your application `config.yml` file.

Here is an example with a `Content` entity, a `content_show` route, using Google shortener service (`googl`):

```yaml
sly_url_shortener:
    entities:
        Acme\DemoBundle\Entity\Content:
            route: content_show # route parameter is required for entities
            provider: googl
            api:
                key: XXXYYYZZZ
```

Another example with a global configuration and a specific `Person` entity one,
using Bitly shortener service (`bitly`) and its API parameters:

```yaml
sly_url_shortener:
    provider: internal
    domain: te.st
    entities:
        Acme\DemoBundle\Entity\Person:
            route: person_show
            provider: bitly
            api:
                username: Me
                key: R_MyS3cr3tK3yMyS3cr3tK3yMyS3cr3tK3y
```

Note that `internal` provider requires a `domain` parameter,
which is your short URLs domain. To granted short links redirection,
your short domain vHost has to point to your project document root,
with using an Apache ServerAlias for example.

## 2. Get/Render an entity short URL from Twig view

Render a short URL from an object/entity is so easy.
You just have to use dedicated `render_short_url` Twig function to do it.

There is 2 cases about short URL redering:

- **A short URL exists:** it will be used for render it
- **There is no existing short URL:** a short URL will be generated before being rendered

Here is a little example:

```php
<?php
// DemoController.php

    /**
     * @Route("/content/{id}.html", name="content_show")
     * @Template()
     */
    public function showContentAction(Content $content)
    {
        return array(
            'content' => $content, // a content is passed to Twig view
        );
    }
```

```twig
{# showContent.html.twig #}

<h2>Here is the title: {{ content.title }}</h2>

<p>Here is the <a href="{{ render_short_url(content) }}">short generated link</a> from Content entity.</p>
```

## 3. Direct use of the UrlShortener Manager service

You can directly use `sly_url_shortener` service to generate short URLs:

```php
<?php
// DemoController.php

    /**
     * @Route("/content/{id}.html", name="content_show")
     * @Template()
     */
    public function showContentAction(Content $content)
    {
        $urlShortener = $this->container->get('sly_url_shortener');

        return new Response(sprintf('My generated content-linked short URL: %s', $urlShortener->getShortUrl($content)));
    }
```

-----

This examples use a short URL rendering from a passed entity object.
It's also possible to use a hash or the long URL to have short one returned.
Nothing will be returned (`null`) if there is no record about it.
