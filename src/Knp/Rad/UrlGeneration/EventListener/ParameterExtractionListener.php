<?php

namespace Knp\Rad\UrlGeneration\EventListener;

use Knp\Rad\UrlGeneration\Routing\ParameterStack;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class ParameterExtractionListener
{
    /**
     * @var ParameterStack
     */
    private $stack;

    /**
     * @param ParameterStack $stack
     */
    public function __construct(ParameterStack $stack)
    {
        $this->stack = $stack;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onRequest(GetResponseEvent $event)
    {
        $request    = $event->getRequest();
        $parameters = $request->attributes->get('_route_params', []);

        foreach ($parameters as $name => $value) {
            $this->stack->set($name, $value);
        }
    }
}
