<?php

namespace Keerill\Integrations\Operations;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

abstract class HttpOperation extends AbstractOperation
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var string
     */
    protected $driver = 'http';

    /**
     * Возвращает тип запроса
     * @return string
     */
    protected function getMethod(): string
    {
        return 'POST';
    }

    /**
     * Возвращает URL запроса
     * @return  string
     */
    protected function getUrl(): string
    {
        return 'localhost';
    }

    /**
     * Возвращает массив заголовков запроса
     * @return array
     */
    protected function getHeaders(): array
    {
        return [];
    }

    /**
     * Возвращает тело запроса
     * @return string
     */
    protected function getBody(): ?string
    {
        return null;
    }

    /**
     * @return Request
     */
    public function createRequest(): Request
    {
        return new Request($this->getMethod(), $this->getUrl(), $this->getHeaders(), $this->getBody());
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return [];
    }

    /**
     * @param ResponseInterface $response
     * @return self
     */
    public function setResponse(ResponseInterface $response): self
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}