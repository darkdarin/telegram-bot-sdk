<?php

namespace DarkDarin\TelegramBotSdk\DTO;

use Psr\Http\Message\StreamInterface;

/**
 * Represents a general file to be sent.
 *
 * @link https://core.telegram.org/bots/api#inputmediadocument
 */
readonly class InputMediaDocument
{
    /**
     * @param StreamInterface|string $media File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass file to upload
     * @param 'document' $type Type of the result, must be video
     * @param StreamInterface|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file
     * @param string|null $caption Caption of the document to be sent, 0-1024 characters after entities parsing
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the document caption
     * @param array<MessageEntity>|null $caption_entities List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $disable_content_type_detection Disables automatic server-side content type detection for files uploaded using multipart/form-data. Always True, if the document is sent as part of an album.
     */
    public function __construct(
        public StreamInterface|string $media,
        public string $type = 'document',
        public StreamInterface|string|null $thumbnail = null,
        public ?string $caption = null,
        public ?ParseModeEnum $parse_mode = null,
        public ?array $caption_entities = null,
        public ?bool $disable_content_type_detection = null,
    ) {}
}
