<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a service message about a video chat scheduled in the chat.
 *
 * @link https://core.telegram.org/bots/api#videochatscheduled
 */
readonly class VideoChatScheduled
{
    /**
     * @param int $start_date Point in time (Unix timestamp) when the video chat is supposed to be started by a chat administrator
     */
    public function __construct(
        public int $start_date,
    ) {}
}
