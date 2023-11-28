<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a chat photo.
 *
 * @link https://core.telegram.org/bots/api#chatphoto
 */
readonly class ChatPhoto
{
    /**
     * @param string $small_file_id File identifier of small (160x160) chat photo. This file_id can be used only for photo download and only for as long as the photo is not changed.
     * @param string $small_file_unique_id Unique file identifier of small (160x160) chat photo, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
     * @param string $big_file_id File identifier of big (640x640) chat photo. This file_id can be used only for photo download and only for as long as the photo is not changed.
     * @param string $big_file_unique_id Unique file identifier of big (640x640) chat photo, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
     */
    public function __construct(
        public string $small_file_id,
        public string $small_file_unique_id,
        public string $big_file_id,
        public string $big_file_unique_id,
    ) {}
}
