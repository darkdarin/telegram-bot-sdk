<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents an inline button that switches the current user to inline mode in a chosen chat, with an optional default inline query.
 *
 * @link https://core.telegram.org/bots/api#switchinlinequerychosenchat
 */
readonly class SwitchInlineQueryChosenChat
{
    /**
     * @param string|null $query Optional. The default inline query to be inserted in the input field. If left empty, only the bot's username will be inserted
     * @param bool|null $allow_user_chats Optional. True, if private chats with users can be chosen
     * @param bool|null $allow_bot_chats Optional. True, if private chats with bots can be chosen
     * @param bool|null $allow_group_chats Optional. True, if group and supergroup chats can be chosen
     * @param bool|null $allow_channel_chats Optional. True, if channel chats can be chosen
     */
    public function __construct(
        public ?string $query = null,
        public ?bool $allow_user_chats = null,
        public ?bool $allow_bot_chats = null,
        public ?bool $allow_group_chats = null,
        public ?bool $allow_channel_chats = null,
    ) {}
}
