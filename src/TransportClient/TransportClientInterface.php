<?php

namespace DarkDarin\TelegramBotSdk\TransportClient;

interface TransportClientInterface
{
    /**
     * @template TObject of object
     * @template TType of string|class-string<TObject>
     * @param string $token
     * @param string $method
     * @param array $parameters
     * @param class-string<TType>|null $responseType
     * @param string|bool|null $multipartField
     * @psalm-return (TType is class-string<TObject> ? TObject : mixed)
     * @return mixed
     */
    public function executeMethod(
        string $token,
        string $method,
        array $parameters,
        ?string $responseType = null,
        string|bool|null $multipartField = null,
    ): mixed;
}
