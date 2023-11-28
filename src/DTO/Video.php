<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a video file.
 *
 * @link https://core.telegram.org/bots/api#video
 */
readonly class Video
{
    /**
     * @param string $file_id Identifier for this file, which can be used to download or reuse the file
     * @param string $file_unique_id Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
     * @param int $width Video width as defined by sender
     * @param int $height Video height as defined by sender
     * @param int $duration Duration of the video in seconds as defined by sender
     * @param PhotoSize|null $thumbnail Optional. Video thumbnail
     * @param string|null $file_name Optional. Original filename as defined by sender
     * @param string|null $mime_type Optional. MIME type of the file as defined by sender
     * @param int|null $file_size Optional. File size in bytes. It can be bigger than 2^31 and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this value.
     */
    public function __construct(
        public string $file_id,
        public string $file_unique_id,
        public int $width,
        public int $height,
        public int $duration,
        public ?PhotoSize $thumbnail = null,
        public ?string $file_name = null,
        public ?string $mime_type = null,
        public ?int $file_size = null,
    ) {}
}
