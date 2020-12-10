<?php

namespace Keerill\Integrations\Classes;

use Keerill\Integrations\Exceptions\DriverException;
use Keerill\Integrations\Interfaces\DriverInterface;
use Keerill\Integrations\Interfaces\OperationInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

class IntegrationManager
{
    /**
     * @var string
     */
    protected $defaultDriver = null;

    /**
     * @var array
     */
    protected $availableDrivers = null;

    /**
     * @param string $defaultDriver
     * @param array $availableDrivers
     */
    public function __construct(string $defaultDriver, array $availableDrivers)
    {
        $this->availableDrivers = $availableDrivers;
        $this->defaultDriver = $defaultDriver;
    }

    /**
     * Создание экземпляра драйвера
     *
     * @param string $class
     * @param array $options
     * @return DriverInterface
     *
     * @throws BindingResolutionException
     */
    protected function createDriver(string $class, array $options) : DriverInterface
    {
        return app()->make($class, compact('options'));
    }

    /**
     * Возвращает конфигурацию выбранного драйвера
     * Если же драйвер с таким именем не найден, то используеться стандартный
     *
     * @param string $driver
     * @return array
     *
     * @throws DriverException
     */
    protected function getSelectedDriver(string $driver = null) : array
    {
        if ($driver !== null) {
            if (!isset($this->availableDrivers[$driver])) {
                throw new DriverException(
                    sprintf('Драйвер с именем %s не найден', $driver)
                );
            }

            return $this->availableDrivers[$driver];
        }

        return $this->availableDrivers[$this->defaultDriver];
    }

    /**
     * Возвращает экземпляр драйвера интеграции
     *
     * @param string $driver
     * @param array $options
     * @return DriverInterface
     *
     * @throws DriverException
     * @throws BindingResolutionException
     */
    public function driver(string $driver = null, array $options = [])
    {
        /**
         * Получение конфигурации для создания экземпляра драйвера
         */
        $selectedDriver = $this->getSelectedDriver($driver);

        /**
         * Создание нового экземпляра драйвера
         */
        return $this->createDriver(
            $selectedDriver['class'],
            array_merge($selectedDriver['options'], $options)
        );
    }

    /**
     * Выполнение запроса
     *
     * @param OperationInterface $operation
     * @return OperationInterface
     *
     * @throws BindingResolutionException
     * @throws DriverException
     */
    public function handle(OperationInterface $operation) : OperationInterface
    {
        return $this->driver($operation->getDriver())
            ->handle($operation);
    }
}
