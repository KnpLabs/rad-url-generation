<?php

namespace spec\Knp\Rad\UrlGeneration\Routing;

use PhpSpec\ObjectBehavior;

class ParameterStackSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Rad\UrlGeneration\Routing\ParameterStack');
    }

    public function it_sets_new_parameters()
    {
        $this->set('foo', 'bar');
        $this->set('baz', 2);

        $this->all()->shouldReturn(['foo' => 'bar', 'baz' => 2]);
        $this->get('foo')->shouldReturn('bar');
        $this->get('baz')->shouldReturn(2);
    }

    public function it_replace_existing_parameter()
    {
        $this->set('foo', 'bar');
        $this->set('baz', 2);
        $this->set('foo', 1);

        $this->all()->shouldReturn(['foo' => 1, 'baz' => 2]);
        $this->get('foo')->shouldReturn(1);
        $this->get('baz')->shouldReturn(2);
    }
}
