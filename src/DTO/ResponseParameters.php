<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * Describes why a request was unsuccessful.
 *
 * @link https://core.telegram.org/bots/api#responseparameters
 */
readonly class ResponseParameters
{
    public function __construct(
        public ?int $migrate_to_chat_id = null,
        public ?int $retry_after = null,
    ) {}
}
