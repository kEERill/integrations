<?php

namespace Keerill\Integrations\Operations;

use Keerill\Integrations\Interfaces\OperationInterface;

abstract class AbstractOperation implements OperationInterface
{
    /**
     * @var string
     */
    protected $driver = 'http';

    /**
     * @return string
     */
    public function getDriver() : string
    {
        return $this->driver;
    }

    /**
     * @param mixed $response
     * @return void
     */
    abstract public function handle(): void;
}