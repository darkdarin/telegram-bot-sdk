<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a unique message identifier.
 *
 * @link https://core.telegram.org/bots/api#messageid
 */
readonly class MessageId
{
    /**
     * @param int $message_id Unique message identifier
     */
    public function __construct(
        public int $message_id,
    ) {}
}
