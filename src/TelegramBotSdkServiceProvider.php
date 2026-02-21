<?php

namespace DarkDarin\TelegramBotSdk;

use DarkDarin\TelegramBotSdk\Commands\CommandHandler;
use DarkDarin\TelegramBotSdk\Commands\CommandHandlerInterface;
use DarkDarin\TelegramBotSdk\Factories\PsrClientFactory;
use DarkDarin\TelegramBotSdk\Factories\PsrRequestFactoryFactory;
use DarkDarin\TelegramBotSdk\Factories\PsrResponseFactoryFactory;
use DarkDarin\TelegramBotSdk\Factories\PsrStreamFactoryFactory;
use DarkDarin\TelegramBotSdk\TransportClient\TransportClient;
use DarkDarin\TelegramBotSdk\TransportClient\TransportClientInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @psalm-api
 */
class TelegramBotSdkServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes(
            [
                __DIR__ . '/../config/telegram.php' => $this->app->configPath('telegram.php'),
            ],
        );
    }

    #[\Override]
    public function register(): void
    {
        $this->app->singleton(ClientInterface::class, (new PsrClientFactory())(...));
        $this->app->singleton(RequestFactoryInterface::class, (new PsrRequestFactoryFactory())(...));
        $this->app->singleton(ResponseFactoryInterface::class, (new PsrResponseFactoryFactory())(...));
        $this->app->singleton(StreamFactoryInterface::class, (new PsrStreamFactoryFactory())(...));
        $this->app->singleton(TransportClientInterface::class, TransportClient::class);
        $this->app->singleton(Telegram::class, function (Container $container) {
            $default = Config::get('telegram.default', 'default');
            $bots = Config::get('telegram.bots', []);

            return new Telegram($bots, $default, $container);
        });

        $this->registerCommandHandler();
    }

    private function registerCommandHandler(): void
    {
        $this->app->singleton(CommandHandlerInterface::class, CommandHandler::class);

        $this->app->afterResolving(
            CommandHandlerInterface::class,
            function (CommandHandlerInterface $commandHandler, Container $container): void {
                $bots = Config::get('telegram.bots', []);

                foreach ($bots as $botName => $config) {
                    if (!empty($config['commands'])) {
                        foreach ($config['commands'] as $command) {
                            $commandHandler->registerCommand($botName, $container->get($command));
                        }
                    }
                }
            },
        );
    }
}
