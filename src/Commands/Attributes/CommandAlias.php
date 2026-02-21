<?php

namespace DarkDarin\TelegramBotSdk\Commands\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
readonly class CommandAlias
{
    public function __construct(
        public string $alias,
    ) {}
}
