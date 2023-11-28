<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents an incoming inline query. When the user sends an empty query, your bot could return some default or trending results.
 *
 * @link https://core.telegram.org/bots/api#inlinequery
 */
readonly class InlineQuery
{
    /**
     * @param string $id Unique identifier for this query
     * @param User $from Sender
     * @param string $query Text of the query (up to 256 characters)
     * @param string $offset Offset of the results to be returned, can be controlled by the bot
     * @param ChatTypeEnum|null $chat_type Optional. Type of the chat from which the inline query was sent. Can be either “sender” for a private chat with the inline query sender, “private”, “group”, “supergroup”, or “channel”. The chat type should be always known for requests sent from official clients and most third-party clients, unless the request was sent from a secret chat
     * @param Location|null $location Optional. Sender location, only for bots that request user location
     */
    public function __construct(
        public string $id,
        public User $from,
        public string $query,
        public string $offset,
        public ?ChatTypeEnum $chat_type = null,
        public ?Location $location = null,
    ) {}
}
