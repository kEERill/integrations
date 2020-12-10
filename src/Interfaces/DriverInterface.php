<?php

namespace Keerill\Integrations\Interfaces;

interface DriverInterface
{
    /**
     * Установка опций для драйвера интеграции
     * @param array $options
     * @return void
     */
    public function setOptions(array $options);

    /**
     * Возвращает установленные параметры
     * @return array
     */
    public function getOptions() : array;

    /**
     * Возвращает значение установленного параметра
     *
     * @param string $name
     * @param string $default
     * @return mixed
     */
    public function getOption(string $name, string $default = null);

    /**
     * Выполнение запроса
     * @param OperationInterface $message
     * @return mixed
     */
    public function handle($message) : OperationInterface;
}