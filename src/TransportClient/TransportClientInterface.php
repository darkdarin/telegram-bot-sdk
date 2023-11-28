<?php

namespace DarkDarin\TelegramBotSdk\TransportClient;

interface TransportClientInterface
{
    public function setToken(string $token): void;

    /**
     * @template TObject of object
     * @template TType of string|class-string<TObject>
     * @param string $method
     * @param array $parameters
     * @param class-string<TType>|null $responseType
     * @param array $uploadFields
     * @psalm-return (TType is class-string<TObject> ? TObject : mixed)
     * @return mixed
     */
    public function executeMethod(
        string $method,
        array $parameters,
        ?string $responseType = null,
        string|bool|null $multipartField = null,
    ): mixed;
}
