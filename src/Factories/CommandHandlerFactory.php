<?php

namespace DarkDarin\TelegramBotSdk\Factories;

use DarkDarin\TelegramBotSdk\Commands\CommandHandler;
use DarkDarin\TelegramBotSdk\Commands\CommandHandlerInterface;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CommandHandlerFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): CommandHandlerInterface
    {
        $config = $container->get(ConfigInterface::class);

        $bots = $config->get('telegram.bots', []);
        /** @var CommandHandler $commandHandler */
        $commandHandler = $container->make(CommandHandler::class);

        foreach ($bots as $botName => $config) {
            if (!empty($config['commands'])) {
                foreach ($config['commands'] as $command) {
                    $commandHandler->registerCommand($botName, $container->get($command));
                }
            }
        }

        return $commandHandler;
    }
}
