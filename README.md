Rapid Application Development : Url Generation
==============================================
Simply auto-complete needed route parameters with existing ones.

[![Build Status](https://travis-ci.org/KnpLabs/rad-url-generation.svg)](https://travis-ci.org/KnpLabs/rad-url-generation)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/KnpLabs/rad-url-generation/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/KnpLabs/rad-url-generation/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/knplabs/rad-url-generation/v/stable.svg)](https://packagist.org/packages/knplabs/rad-url-generation) [![Total Downloads](https://poser.pugx.org/knplabs/rad-url-generation/downloads.svg)](https://packagist.org/packages/knplabs/rad-url-generation) [![Latest Unstable Version](https://poser.pugx.org/knplabs/rad-url-generation/v/unstable.svg)](https://packagist.org/packages/knplabs/rad-url-generation) [![License](https://poser.pugx.org/knplabs/rad-url-generation/license.svg)](https://packagist.org/packages/knplabs/rad-url-generation)

#Installation

```bash
composer require knplabs/rad-url-generation ~1.0
```

```php
class AppKernel
{
    function registerBundles()
    {
        $bundles = array(
            //...
            new Knp\Rad\UrlGeneration\Bundle\UrlGenerationBundle(),
            //...
        );

        //...

        return $bundles;
    }
}
```

#Usages

Just continue to use former url generation, nothing changes concerning the implementation. The only change is you don't repeat current route parameters anymore.

##Example 1

Current route:
```yml
app_products_show:
    path: /shops/{shop}/products/{products}/
```

My current url is /shops/12/products/345/. I want to build again the same url. Should I repeat route parameters if it already is my current route?

Nope.
```php
$router->generate('app_products_show');                                  // Returns /shops/12/products/345/
$router->generate('app_products_show', ['product' => 122]);              // Returns /shops/12/products/122/
$router->generate('app_products_show', ['shop' => 1]);                   // Returns /shops/1/products/345/
$router->generate('app_products_show', ['shop' => 1, 'product' => 122]); // Returns /shops/1/products/122/
```

##Example 2

Current route:
```yml
app_products_show:
    path: /shops/{shop}/products/{products}/
```
Current URL: `/shops/1/products/122/`

I want to build this URL
```yml
app_variant_show:
    path: /shops/{shop}/products/{products}/variants/{variant}/
```

I could execute:
```php
$router->generate('app_variant_show', ['shop' => 1, 'product' => 122, 'variant' => 23]); // Returns /shops/1/products/122/variants/23/
```

But why should I repeat already existing parameters ?
```php
$router->generate('app_variant_show', ['variant' => 23]); // Returns /shops/1/products/122/variants/23/
```

#Works with

- Router service : `$container->get('router')->generate('app_products_show')`.
- Controller shortcuts: `$this->generateUrl('app_products_show')` and `$this->redirectToRoute('app_products_show')`.
- Twig functions: `path('app_products_show')` or `url('app_products_show')`.
- Everything else using the Symfony router.
