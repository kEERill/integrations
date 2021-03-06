<?php

return [
        /*
    |--------------------------------------------------------------------------
    | Статус работы интеграционной системы
    |--------------------------------------------------------------------------
    |
    | Если этот параметр равен "false", то никаких дополнительных обработок
    | лида не производяться
    |
    */
    'enabled' => env('INTEGRATION_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Драйвера
    |--------------------------------------------------------------------------
    |
    | Список драйверов, которые можно использовать для интеграции с банками
    |
    */
    'drivers' => [

        /**
         * Драйвер для работы с API банка посредством HTTP запросами
         */
        'http' => [
            'class' => \Keerill\Integrations\Drivers\HttpDriver::class,
            'options' => [
                'logs' => null
            ]
        ]
    ]
];