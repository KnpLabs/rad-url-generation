<?php

namespace Knp\Rad\UrlGeneration\Routing;


class ParameterStack
{
    /**
     * @var mixed[]
     */
    private $parameters;

    public function __construct()
    {
        $this->parameters = [];
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function set($name, $value)
    {
        $this->parameters[$name] = $value;
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
    public function all()
    {
        return $this->parameters;
    }
}
