<?php

namespace Knp\Rad\UrlGeneration\Routing;

use Knp\Rad\UrlGeneration\Routing\ParameterStack;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @var RouterInterface $router
     */
    private $router;

    /**
     * @var ParameterStack $parameters
     */
    private $parameters;

    /**
     * @param RouterInterface $router
     * @param ParameterStack  $parameters
     */
    public function __construct(RouterInterface $router, ParameterStack $parameters)
    {
        $this->router     = $router;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteCollection()
    {
        return $this->router->getRouteCollection();
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
}
