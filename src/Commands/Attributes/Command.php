<?php

namespace DarkDarin\TelegramBotSdk\Commands\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS)]
readonly class Command
{
    public function __construct(
        public string $name,
        public ?string $description,
    ) {
    }
}
