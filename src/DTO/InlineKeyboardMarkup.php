<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents an inline keyboard that appears right next to the message it belongs to.
 *
 * @link https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
readonly class InlineKeyboardMarkup
{
    /**
     * @param array<array<InlineKeyboardButton>> $inline_keyboard Array of button rows, each represented by an Array of InlineKeyboardButton objects
     */
    public function __construct(
        public array $inline_keyboard,
    ) {}
}
