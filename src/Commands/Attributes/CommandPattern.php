<?php

namespace DarkDarin\TelegramBotSdk\Commands\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS)]
readonly class CommandPattern
{
    public function __construct(
        public string $pattern,
    ) {}
}
