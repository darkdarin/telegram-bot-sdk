<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents one special entity in a text message. For example, hashtags, usernames, URLs, etc.
 *
 * @link https://core.telegram.org/bots/api#messageentity
 */
readonly class MessageEntity
{
    /**
     * @param MessageEntityTypeEnum $type Type of the entity
     * @param int $offset Offset in UTF-16 code units to the start of the entity
     * @param int $length Length of the entity in UTF-16 code units
     * @param string|null $url Optional. For “text_link” only, URL that will be opened after user taps on the text
     * @param User|null $user Optional. For “text_mention” only, the mentioned user
     * @param string|null $language Optional. For “pre” only, the programming language of the entity text
     * @param string|null $custom_emoji_id Optional. For “custom_emoji” only, unique identifier of the custom emoji. Use getCustomEmojiStickers to get full information about the sticker
     */
    public function __construct(
        public MessageEntityTypeEnum $type,
        public int $offset,
        public int $length,
        public ?string $url = null,
        public ?User $user = null,
        public ?string $language = null,
        public ?string $custom_emoji_id = null,
    ) {
    }

    /**
     * Correct way for get entity value from text by offset and length
     *
     * @see https://core.telegram.org/api/entities#entity-length
     *
     * @param string $text
     * @return string
     */
    public function getValue(string $text): string
    {
        $textBytes = unpack('C*', $text);
        $value = [];
        $offset = 0;

        foreach ($textBytes as $byte) {
            if ($offset >= $this->offset && $offset <= $this->offset + $this->length) {
                $value[] = $byte;
            }
            if (($byte & 0xc0) != 0x80) {
                $offset += ($byte >= 0xf0 ? 2 : 1);
            }
        }

        return rtrim(pack('C*', ...$value));
    }
}
