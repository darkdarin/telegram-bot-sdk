<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a service message about a new forum topic created in the chat.
 *
 * @link https://core.telegram.org/bots/api#forumtopiccreated
 */
readonly class ForumTopicCreated
{
    /**
     * @param string $name Name of the topic
     * @param int $icon_color Color of the topic icon in RGB format
     * @param string|null $icon_custom_emoji_id Optional. Unique identifier of the custom emoji shown as the topic icon
     */
    public function __construct(
        public string $name,
        public int $icon_color,
        public ?string $icon_custom_emoji_id = null,
    ) {}
}
