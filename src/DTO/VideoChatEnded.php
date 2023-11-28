<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a service message about a video chat ended in the chat.
 *
 * @link https://core.telegram.org/bots/api#videochatended
 */
readonly class VideoChatEnded
{
    /**
     * @param int $duration Video chat duration in seconds
     */
    public function __construct(
        public int $duration,
    ) {}
}
