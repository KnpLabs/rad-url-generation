<?php

namespace Knp\Rad\UrlGeneration\Routing;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class ParameterStack
{
    /**
     * @var mixed[] $parameters
     */
    private $parameters = [];

    /**
     * @param GetResponseEvent $event
     *
     * @return void
     */
    public function onRequest(GetResponseEvent $event)
    {
        $request    = $event->getRequest();
        $parameters = $request->attributes->get('_route_params', []);

        $this->parameters = array_merge($this->parameters, $parameters);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function get($name)
    {
        return true === array_key_exists($name, $this->parameters)
            ? $this->parameters[$name]
            : null
        ;
    }

    /**
     * @return mixed[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
