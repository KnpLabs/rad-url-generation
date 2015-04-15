<?php

namespace spec\Knp\Rad\UrlGeneration\EventListener;

use Knp\Rad\UrlGeneration\Routing\ParameterStack;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class ParameterExtractionListenerSpec extends ObjectBehavior
{
    public function let(ParameterBag $attributes, Request $request, GetResponseEvent $event, ParameterStack $stack)
    {
        $event->getRequest()->willReturn($request);
        $request->attributes = $attributes;

        $attributes->get('_route_params', Argument::any())->willReturn(['foo' => 'bar', 'baz' => 2]);

        $this->beConstructedWith($stack);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Rad\UrlGeneration\EventListener\ParameterExtractionListener');
    }

    public function it_registers_parameters($event, $stack)
    {
        $stack->set('foo', 'bar')->shouldBeCalled();
        $stack->set('baz', 2)->shouldBeCalled();

        $this->onRequest($event);
    }
}
