<?php

namespace DarkDarin\TelegramBotSdk;

use Argo\EntityDefinition\Reflector\MethodDefinition\MethodDefinitionReflectorInterface;
use Argo\RestClient\Serializer\RestClientSerializerInterface;
use DarkDarin\TelegramBotSdk\Commands\CommandHandlerInterface;
use DarkDarin\TelegramBotSdk\Exceptions\MisconfiguredClientException;
use DarkDarin\TelegramBotSdk\TransportClient\TelegramRequestFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Client\ClientInterface;

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
            if (empty($config['token'])) {
                throw new MisconfiguredClientException(
                    sprintf('Need set token in configuration for bot [%s]', $botName),
                );
            }
            $this->clients[$botName] = $this->makeClientInstance($botName)->withToken($config['token']);
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
        return $this->getClientInstance()->$method(...$params);
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
    protected function makeClientInstance(string $botName): TelegramClient
    {
        return new TelegramClient(
            $botName,
            $this->container->get(TelegramRequestFactoryInterface::class),
            $this->container->get(ClientInterface::class),
            $this->container->get(MethodDefinitionReflectorInterface::class),
            $this->container->get(RestClientSerializerInterface::class),
            $this->container->get(CommandHandlerInterface::class),
        );
    }
}
