# NeoxSeoBundle { Symfony 6 } BETA* only dev-master
This bundle provides a simple and flexible to provide Seo functionality for developers.
Tow way to use : 1 - Attribute 2 - Injection & 1+2 😉

[![2023-09-29-12-02-44.png](https://i.postimg.cc/HnKB63d2/2023-09-29-12-02-44.png)](https://postimg.cc/kRQQ4QV6)
## Installation !!
Install the bundle for Composer !! as is still on beta version !!

````
  composer require xorgxx/neox-seo-bundle
  or 
  composer require xorgxx/neox-seo-bundle:0.*
````

Make sure that is register the bundle in your AppKernel:
```php
Bundles.php
<?php

return [
    .....
    NeoxSeo\NeoxSeoBundle\neoxSeoBundle::class => ['all' => true],
    .....
];
```

**NOTE:** _You may need to use [ symfony composer dump-autoload ] to reload autoloading_

 ..... Done 🎈

## !! you style need to make configuration !! 
it at this time we ded not optimize all !!

## Configuration
* Install and configure  ==> [Symfony config](https://symfony.com/doc/current/notifier.html#installation)
* Creat neox_seo.yaml in config folder
```
└─── config
│   └─── packages
│       └─── neox_seo.yaml
|       └─── ..... 
```
## neox_seo.yaml
It set automatique but you can custom
```
   neox_seo:
      seo:
          title: '%name_projet% Bienvenue | Creation de site web, mobile, application station'
          charset: "utf-8"
          link:
              alternate@FR: hreflang="fr" href="https://www.xxxxx.wip/fr"
              alternate@En: hreflang="en" href="https://www.xxxxx.wip/en"
              icon:       href="data:image/svg+xml,<svg xmlns=http://www.w3.org/2000/svg viewBox=0 0 128 128><text y=1.2em font-size=96>⚫️</text></svg>"
          metas:
              metasHttpEquiv:
                  content-type:       "text/html; charset=utf-8"
                  x-ua-compatible:    "IE=edge"
                  viewport:           "width=device-width, initial-scale=1"
              metasName:
                  description: |
                      %name_projet% ....
                  image: '%web_site%/images/logo/logoWhite.png' # This one is shared by open graph and twitter only
                  # TWITTER
                  "twitter:card": summary
              metasProperty:
                  # FACEBOOK
                  "og:description": blablabla.
              metasItemprop:
          html:
              lang: fr
```

## How to use ?

By attribute name
```php
    myController.php
    <?php
    #[NeoxSeo( title: 'home page', charset: 'UTF-8', metasHttpEquiv: ['Content-Type'=>'text/html; charset=utf-4', 'Accept'=>'text/html; charset=utf-8'])]
    class HomeController extends _CoreController
    {
            #[Route('/{id}/send', name: 'app_admin_tokyo_crud_send', methods: ['GET'])]
            #[NeoxSeo( title: 'home index', metasName: ['keywords' =>'bar', 'description' => 'foo', 'robots' => 'index,follow'])]
            public function index( Request $request): Response
            {
                ....
            }

```
By injection  
```php
    myController.php
    <?php
    #[NeoxSeo( title: 'home page', charset: 'UTF-8', metasHttpEquiv: ['Content-Type'=>'text/html; charset=utf-4', 'Accept'=>'text/html; charset=utf-8'])]
    class HomeController extends _CoreController
    {
          /**
           * @param NeoxSeoService $neoxSeoService
           *
           * @return Response
           */
           
            #[Route('/{id}/send', name: 'app_admin_tokyo_crud_send', methods: ['GET'])]
            #[NeoxSeo( title: 'home index', metasName: ['keywords' =>'bar', 'description' => 'foo', 'robots' => 'index,follow'])]
            public function index(NeoxSeoService $neoxSeoService): Response
            {
                $neoxSeoService->getSeoBag()
                  ->setTitle("home-page")
                  ->setMetasHttpEquiv([
                      'Content-Type'=>'text/html; charset=utf-56',
                      'Accept'=>'text/html; charset=utf-8',
                      'capnord'=>'text/html; charset=utf-8',
                 ])
                 ;
            }
            .....

```

Setup twig balise 
```twig
  <html {{ neoxSeoHtmlAttributes()|raw }}>
  <head>
        {{ neoxSeoTitle()|raw }}
        {{ neoxSeoMetadata()|raw }}
        {{ neoxSeoLink()|raw }}
```
..... Done 🎈🎉🎉🎉

## Contributing
If you want to contribute \(thank you!\) to this bundle, here are some guidelines:

* Please respect the [Symfony guidelines](http://symfony.com/doc/current/contributing/code/standards.html)
* Test everything! Please add tests cases to the tests/ directory when:
    * You fix a bug that wasn't covered before
    * You add a new feature
    * You see code that works but isn't covered by any tests \(there is a special place in heaven for you\)

## Todo list
* Breadcrumb 
* Sitemap

## Thanks
