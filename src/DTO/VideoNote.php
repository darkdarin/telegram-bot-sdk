<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a video message (available in Telegram apps as of v.4.0).
 *
 * @link https://core.telegram.org/bots/api#videonote
 */
readonly class VideoNote
{
    /**
     * @param string $file_id Identifier for this file, which can be used to download or reuse the file
     * @param string $file_unique_id Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
     * @param int $length Video width and height (diameter of the video message) as defined by sender
     * @param int $duration Duration of the video in seconds as defined by sender
     * @param PhotoSize|null $thumbnail Optional. Video thumbnail
     * @param int|null $file_size Optional. File size in bytes
     */
    public function __construct(
        public string $file_id,
        public string $file_unique_id,
        public int $length,
        public int $duration,
        public ?PhotoSize $thumbnail,
        public ?int $file_size,
    ) {}
}
