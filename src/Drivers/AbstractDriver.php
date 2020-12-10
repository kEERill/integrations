<?php

namespace Keerill\Integrations\Drivers;

use Keerill\Integrations\Interfaces\DriverInterface;
use Keerill\Integrations\Interfaces\OperationInterface;

abstract class AbstractDriver implements DriverInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @param array $options
     * @return void
     */
    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }

    /**
     * @param array $options
     * @return self
     */
    public function setOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions() : array
    {
        return $this->options;
    }

    /**
     * @param string $name
     * @param string $default
     * @return mixed
     */
    public function getOption(string $name, string $default = null)
    {
        return $this->options[$name] ?? $default;
    }

    /**
     * @param $operation
     * @return OperationInterface
     */
    public function handle($operation) : OperationInterface
    {
        $operation->handle();
        
        return $operation;
    }
}