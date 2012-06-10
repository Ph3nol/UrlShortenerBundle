SlyUrlShortenerBundle
====================

- [Installation](https://github.com/Ph3nol/UrlShortenerBundle/blob/master/Resources/doc/install.markdown)
- [Usage](https://github.com/Ph3nol/UrlShortenerBundle/blob/master/Resources/doc/usage.markdown)
- [Example](https://github.com/Ph3nol/UrlShortenerBundle/blob/master/Resources/doc/example.markdown) (soon)

# Services

Several services are available to generate short URLs and linked them to your contents/entities.

- **Link** This entity contains all short distant and internal generated short links
- **Provider** This service provides short URLs from internal process or distant APIs
- **Router** This service generates routes from declared entities ones you will declare into
the project main configuration file
- **Manager** This main service is the full manager of this bundle
- **Shortener** This service manage links shortening
- **Twig Extension** This extension allow you an easy access to short URLs generation and render

# The Link linkage idea

Each generated short link is recorded with some informations that allows it to be linked to
a content (or an entity).

This linkage is done from 2 informations: the object entity
(example : `Acme\DemoBundle\Entity\Content`) and the object ID.