<?php

namespace DarkDarin\TelegramBotSdk;

use DarkDarin\TelegramBotSdk\Factories\PsrClientFactory;
use DarkDarin\TelegramBotSdk\Factories\PsrRequestFactoryFactory;
use DarkDarin\TelegramBotSdk\Factories\PsrResponseFactoryFactory;
use DarkDarin\TelegramBotSdk\Factories\PsrStreamFactoryFactory;
use DarkDarin\TelegramBotSdk\Factories\TelegramFactory;
use DarkDarin\TelegramBotSdk\TransportClient\TransportClient;
use DarkDarin\TelegramBotSdk\TransportClient\TransportClientInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                ClientInterface::class => PsrClientFactory::class,
                RequestFactoryInterface::class => PsrRequestFactoryFactory::class,
                ResponseFactoryInterface::class => PsrResponseFactoryFactory::class,
                StreamFactoryInterface::class => PsrStreamFactoryFactory::class,
                TransportClientInterface::class => TransportClient::class,
                Telegram::class => TelegramFactory::class,
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for telegram',
                    'source' => __DIR__ . '/../config/telegram.php',
                    'destination' => (defined('BASE_PATH') ? BASE_PATH : '') . '/config/autoload/telegram.php',
                ],
            ],

        ];
    }
}
