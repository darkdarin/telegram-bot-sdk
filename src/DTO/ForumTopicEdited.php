<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a service message about an edited forum topic.
 *
 * @link https://core.telegram.org/bots/api#forumtopicedited
 */
readonly class ForumTopicEdited
{
    /**
     * @param string|null $name Optional. New name of the topic, if it was edited
     * @param string|null $icon_custom_emoji_id Optional. New identifier of the custom emoji shown as the topic icon, if it was edited; an empty string if the icon was removed
     */
    public function __construct(
        public ?string $name = null,
        public ?string $icon_custom_emoji_id = null,
    ) {}
}
