<?php

namespace spec\Knp\Rad\UrlGeneration\Routing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class ParameterStackSpec extends ObjectBehavior
{
    function let(ParameterBag $attributes, Request $request, GetResponseEvent $event)
    {
        $event->getRequest()->willReturn($request);
        $request->attributes = $attributes;

        $attributes->get('_route_params', Argument::any())->willReturn(['foo' => 'bar', 'baz' => 2]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Rad\UrlGeneration\Routing\ParameterStack');
    }

    function it_registers_parameters($event)
    {
        $this->onRequest($event);

        $this->getParameters()->shouldReturn(['foo' => 'bar', 'baz' => 2]);
    }

    function it_return_parameter_if_exists($event)
    {
        $this->onRequest($event);

        $this->get('foo')->shouldReturn('bar');
        $this->get('baz')->shouldReturn(2);
    }

    function it_returns_null_if_doesnt_exists($event)
    {
        $this->onRequest($event);

        $this->get('null')->shouldReturn(null);
    }
}
