<?php

namespace DarkDarin\TelegramBotSdk;

use DarkDarin\TelegramBotSdk\Exceptions\MisconfiguredClientException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @psalm-api
 * @mixin TelegramClient
 */
class Telegram
{
    /** @var array<string, TelegramClient> */
    private array $clients = [];

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(
        array $bots,
        private readonly string $defaultBotName,
        private readonly ContainerInterface $container,
    ) {
        foreach ($bots as $botName => $config) {
            $this->clients[$botName] = $this->makeClientInstance($config['token']);
        }
    }

    public function bot(?string $botName = null): TelegramClient
    {
        return $this->getClientInstance($botName);
    }

    /**
     * @return array<string, TelegramClient>
     */
    public function bots(): array
    {
        return $this->clients;
    }

    public function __call(string $method, array $params): mixed
    {
        $client = $this->getClientInstance();
        return $client->$method(...$params);
    }

    private function getClientInstance(?string $botName = null): TelegramClient
    {
        if ($botName === null) {
            $botName = $this->defaultBotName;
        }
        if (!array_key_exists($botName, $this->clients)) {
            throw new MisconfiguredClientException();
        }

        return $this->clients[$botName];
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function makeClientInstance(string $token = null): TelegramClient
    {
        $client = $this->container->get(TelegramClient::class);
        if ($token !== null) {
            $client->setToken($token);
        }

        return $client;
    }
}
