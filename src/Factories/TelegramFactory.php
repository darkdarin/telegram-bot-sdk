<?php

namespace DarkDarin\TelegramBotSdk\Factories;

use DarkDarin\TelegramBotSdk\Telegram;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TelegramFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): Telegram
    {
        $config = $container->get(ConfigInterface::class);

        $default = $config->get('telegram.default', 'default');
        $bots = $config->get('telegram.bots', []);

        return new Telegram($bots, $default, $container);
    }
}
