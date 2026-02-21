<?php

namespace DarkDarin\TelegramBotSdk\Commands;

readonly class MessageCommand
{
    public function __construct(
        public string $command,
        public string $arguments,
    ) {}
}
