<?php

namespace Knp\Rad\UrlGeneration\Routing;

use Symfony\Component\Config\ConfigCacheFactory;
use Symfony\Component\Config\ConfigCacheInterface;
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;

class Router implements RouterInterface, WarmableInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var ParameterStack
     */
    private $parameters;

    /** @var RouteCollection|null */
    private $collection;

    /** @var string */
    private $cacheDir;

    /** @var boolean */
    private $debug;

    /**
     * @param RouterInterface $router
     * @param ParameterStack  $parameters
     * @param string          $cacheDir
     * @param boolean         $debug
     */
    public function __construct(RouterInterface $router, ParameterStack $parameters, $cacheDir, $debug)
    {
        $this->router     = $router;
        $this->parameters = $parameters;
        $this->cacheDir   = $cacheDir;
        $this->debug      = $debug;
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteCollection()
    {
        if ($this->collection === null) {
            $factory = new ConfigCacheFactory($this->debug);
            $cache = $factory->cache(sprintf('%s/appRouteCollection.php', $this->cacheDir),
                function (ConfigCacheInterface $cache) {
                    $serialized = sprintf(
                        "<?php\nreturn '%s';",
                        serialize($this->router->getRouteCollection())
                    );

                    $cache->write($serialized, $this->router->getRouteCollection()->getResources());
                }
            );

            $serialized = require_once $cache->getPath();

            $this->collection = unserialize($serialized);
        }

        return $this->collection;
    }

    /**
     * {@inheritdoc}
     */
    public function match($pathinfo)
    {
        return $this->router->match($pathinfo);
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(RequestContext $context)
    {
        return $this->router->setContext($context);
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return $this->router->getContext();
    }

    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        if (null !== $route = $this->getRouteCollection()->get($name)) {
            $compiled  = $route->compile();
            $variables = $compiled->getVariables();

            foreach ($variables as $key) {
                if (false === array_key_exists($key, $parameters)) {
                    $parameters[$key] = $this->parameters->get($key);
                }
            }
        }

        return $this->router->generate($name, $parameters, $referenceType);
    }

    /**
     * {@inheritdoc}
     */
    public function warmUp($cacheDir)
    {
        if ($this->router instanceof WarmableInterface) {
            $this->router->warmUp($cacheDir);
        }

        $currentDir = $this->cacheDIr;
        $this->cacheDir = $cacheDir;

        $this->getRouteCollection();

        $this->cacheDir = $currentDir;
    }
}
