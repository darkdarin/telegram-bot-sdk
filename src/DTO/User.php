<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a Telegram user or bot.
 *
 * @link https://core.telegram.org/bots/api#user
 */
readonly class User
{
    /**
     * @param int $id Unique identifier for this user or bot. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
     * @param bool $is_bot True, if this user is a bot
     * @param string $first_name User's or bot's first name
     * @param string|null $last_name Optional. User's or bot's last name
     * @param string|null $username Optional. User's or bot's username
     * @param string|null $language_code Optional. IETF language tag of the user's language
     * @param bool $is_premium Optional. True, if this user is a Telegram Premium user
     * @param bool $added_to_attachment_menu Optional. True, if this user added the bot to the attachment menu
     * @param bool|null $can_join_groups Optional. True, if the bot can be invited to groups. Returned only in getMe.
     * @param bool|null $can_read_all_group_messages Optional. True, if privacy mode is disabled for the bot. Returned only in getMe.
     * @param bool|null $supports_inline_queries Optional. True, if the bot supports inline queries. Returned only in getMe.
     */
    public function __construct(
        public int $id,
        public bool $is_bot,
        public string $first_name,
        public ?string $last_name = null,
        public ?string $username = null,
        public ?string $language_code = null,
        public bool $is_premium = false,
        public bool $added_to_attachment_menu = false,
        public ?bool $can_join_groups = null,
        public ?bool $can_read_all_group_messages = null,
        public ?bool $supports_inline_queries = null,
    ) {}
}
