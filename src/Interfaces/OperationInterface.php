<?php

namespace Keerill\Integrations\Interfaces;

interface OperationInterface
{
    /**
     * @return string
     */
    public function getDriver() : string;

    /**
     * Выполнения операции
     *
     * @param mixed $driverResponse
     * @return void
     */
    public function handle($driverResponse = null) : void;
}
