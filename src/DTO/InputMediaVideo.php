<?php

namespace DarkDarin\TelegramBotSdk\DTO;

use Psr\Http\Message\StreamInterface;

/**
 * Represents a video to be sent.
 *
 * @link https://core.telegram.org/bots/api#inputmediavideo
 */
readonly class InputMediaVideo
{
    /**
     * @param StreamInterface|string $media File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass file to upload
     * @param 'video' $type Type of the result, must be video
     * @param StreamInterface|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file
     * @param string|null $caption Caption of the video to be sent, 0-1024 characters after entities parsing
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the video caption
     * @param array<MessageEntity>|null $caption_entities List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param int|null $width Video width
     * @param int|null $height Video height
     * @param int|null $duration Video duration in seconds
     * @param bool|null $supports_streaming Pass True if the uploaded video is suitable for streaming
     * @param bool|null $has_spoiler Pass True if the video needs to be covered with a spoiler animation
     */
    public function __construct(
        public StreamInterface|string $media,
        public string $type = 'video',
        public StreamInterface|string|null $thumbnail = null,
        public ?string $caption = null,
        public ?ParseModeEnum $parse_mode = null,
        public ?array $caption_entities = null,
        public ?int $width = null,
        public ?int $height = null,
        public ?int $duration = null,
        public ?bool $supports_streaming = null,
        public ?bool $has_spoiler = null,
    ) {}
}
