<?php

namespace spec\Knp\Rad\UrlGeneration\Routing;

use Knp\Rad\UrlGeneration\Routing\ParameterStack;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Routing\CompiledRoute;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;

class RouterSpec extends ObjectBehavior
{
    function let(RouterInterface $router, ParameterStack $parameters, RouteCollection $routes, Route $route, CompiledRoute $compiled)
    {
        $this->beConstructedWith($router, $parameters);

        $router->getRouteCollection()->willReturn($routes);
        $routes->get(Argument::type('string'))->willReturn(null);
        $routes->get('my_route')->willReturn($route);

        $route->compile()->willReturn($compiled);

        $compiled->getVariables()->willReturn(['p1', 'p2']);

        $parameters->get('p2')->willReturn(2);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Rad\UrlGeneration\Routing\Router');
    }

    function it_autocompletes_with_parameters($router)
    {
        $router
            ->generate('my_route', [ 'p1' => 1, 'p2' => 2 ], RouterInterface::ABSOLUTE_URL)
            ->willReturn('http://myroute/1/2')
            ->shouldBeCalled()
        ;

        $this
            ->generate('my_route', [ 'p1' => 1 ], RouterInterface::ABSOLUTE_URL)
            ->shouldReturn('http://myroute/1/2')
        ;
    }

    function it_just_call_router_if_route_doesnt_exists($router)
    {
        $router->generate('other', [ 'arg' => 'test' ], RouterInterface::ABSOLUTE_PATH)->shouldBeCalled();

        $this
            ->generate('other', [ 'arg' => 'test' ], RouterInterface::ABSOLUTE_PATH)
        ;
    }
}
