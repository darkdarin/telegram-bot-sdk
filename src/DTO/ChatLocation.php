<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * Represents a location to which a chat is connected.
 *
 * @link https://core.telegram.org/bots/api#chatlocation
 */
readonly class ChatLocation
{
    /**
     * @param Location $location The location to which the supergroup is connected. Can't be a live location.
     * @param string $address Location address; 1-64 characters, as defined by the chat owner
     */
    public function __construct(
        public Location $location,
        public string $address,
    ) {}
}
