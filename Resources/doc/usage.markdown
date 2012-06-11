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
            provider: googl
            route: content_show
```

Another example with a `Person` entity, a `person_show` route, using Bitly shortener service (`bitly`):

```yaml
sly_url_shortener:
    entities:
        Acme\DemoBundle\Entity\Person:
            provider: bitly
            api:
                username: Me
                key: R_MyS3cr3tK3yMyS3cr3tK3yMyS3cr3tK3y
            route: person_show
```

As you can see, some providers (like bit.ly) needs API informations.
These are declared with `api` array, which can accept `username`, `password` and `key`,
in function of what providers need.

Soon: an `internal` provider will be used for a self and independant short links management.

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
    public function showContent(Content $content)
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

This example uses a short URL rendering from a passed entity object.
It's also possible to use a hash or the long URL to have short one returned.
Nothing will be returned (`null`) if there is no record about it.