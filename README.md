Rapid Application Development : Url Generation
==============================================
Simply auto-complete needed route parameters with existing ones.

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

You just have to continue to use former url generation, nothing changes concerning the implementation. The only changes is that you don't have to repeat current route parameters anymore
