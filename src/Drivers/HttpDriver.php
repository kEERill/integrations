<?php

namespace Keerill\Integrations\Drivers;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use Illuminate\Support\Facades\Log;
use Keerill\Integrations\Operations\HttpOperation;
use Keerill\Integrations\Interfaces\OperationInterface;

class HttpDriver extends AbstractDriver
{
        /**
     * @var int
     */
    const Timeout = 20;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $options = [
        'logs' => null
    ];

    /**
     * @return Client
     */
    protected function createClient(array $config = []) : Client
    {
        $options = ['timeout' => static::Timeout];

        if ($this->getOption('logs'))
        {
            $options['handler'] = $this->createLoggingHandlerStack([
                '{method} {uri} HTTP/{version} {req_body}',
                'RESPONSE {uri}: {code} - {res_body}'
            ]);
        }

        return new Client(array_merge($options, $config));
    }

    /**
     * @param array $messageFormats
     * @return HandlerStack
     */
    protected function createLoggingHandlerStack(array $messageFormats) : HandlerStack
    {
        $stack = HandlerStack::create();

        collect($messageFormats)->each(function ($messageFormat) use ($stack) {
            $stack->unshift(
                $this->createGuzzleLoggingMiddleware($messageFormat)
            );
        });

        return $stack;
    }

    /**
     * @param string $messageFormat
     * @return mixed
     */
    protected function createGuzzleLoggingMiddleware(string $messageFormat)
    {
        return Middleware::log(
            Log::channel($this->getOption('logs')), new MessageFormatter($messageFormat)
        );
    }

    /**
     * @param HttpOperation $operation
     * @return mixed
     */
    public function handle($operation) : OperationInterface
    {
        $response = $this->createClient()
            ->send($operation->createRequest(), $operation->getOptions());

        $operation->setResponse($response);

        return parent::handle($operation);
    }
}