<?php

namespace DarkDarin\TelegramBotSdk\Commands;

use DarkDarin\TelegramBotSdk\DTO\Message;

interface CommandHandlerInterface
{
    public function registerCommand(string $botName, object $command): void;

    public function handle(string $botName, Message $message): void;
}
