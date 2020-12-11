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
     * @return void
     */
    public function handle() : void;
}
