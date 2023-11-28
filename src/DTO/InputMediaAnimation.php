<?php

namespace DarkDarin\TelegramBotSdk\DTO;

use Psr\Http\Message\StreamInterface;

/**
 * Represents an animation file (GIF or H.264/MPEG-4 AVC video without sound) to be sent.
 *
 * @link https://core.telegram.org/bots/api#inputmediaanimation
 */
readonly class InputMediaAnimation
{
    /**
     * @param StreamInterface|string $media File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass file to upload
     * @param 'animation' $type Type of the result, must be video
     * @param StreamInterface|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Thumbnails can't be reused and can be only uploaded as a new file
     * @param string|null $caption Caption of the animation to be sent, 0-1024 characters after entities parsing
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the animation caption
     * @param array<MessageEntity>|null $caption_entities List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param int|null $width Animation width
     * @param int|null $height Animation height
     * @param int|null $duration Animation duration in seconds
     * @param bool|null $has_spoiler Pass True if the animation needs to be covered with a spoiler animation
     */
    public function __construct(
        public StreamInterface|string $media,
        public string $type = 'animation',
        public StreamInterface|string|null $thumbnail = null,
        public ?string $caption = null,
        public ?ParseModeEnum $parse_mode = null,
        public ?array $caption_entities = null,
        public ?int $width = null,
        public ?int $height = null,
        public ?int $duration = null,
        public ?bool $has_spoiler = null
    ) {}
}
