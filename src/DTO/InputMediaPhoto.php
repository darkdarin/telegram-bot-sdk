<?php

namespace DarkDarin\TelegramBotSdk\DTO;

use Psr\Http\Message\StreamInterface;

/**
 * Represents a photo to be sent.
 *
 * @link https://core.telegram.org/bots/api#inputmediaphoto
 */
readonly class InputMediaPhoto
{
    /**
     * @param StreamInterface|string $media File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass file to upload
     * @param 'photo' $type Type of the result, must be video
     * @param StreamInterface|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file
     * @param string|null $caption Caption of the photo to be sent, 0-1024 characters after entities parsing
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the photo caption
     * @param array<MessageEntity>|null $caption_entities List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $has_spoiler Pass True if the photo needs to be covered with a spoiler animation
     */
    public function __construct(
        public StreamInterface|string $media,
        public string $type = 'photo',
        public StreamInterface|string|null $thumbnail = null,
        public ?string $caption = null,
        public ?ParseModeEnum $parse_mode = null,
        public ?array $caption_entities = null,
        public ?bool $has_spoiler = null
    ) {}
}
