<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a game. Use BotFather to create and edit games, their short names will act as unique identifiers.
 *
 * @link https://core.telegram.org/bots/api#game
 */
readonly class Game
{
    /**
     * @param string $title Title of the game
     * @param string $description Description of the game
     * @param array<PhotoSize> $photo Photo that will be displayed in the game message in chats.
     * @param string|null $text Optional. Brief description of the game or high scores included in the game message. Can be automatically edited to include current high scores for the game when the bot calls setGameScore, or manually edited using editMessageText. 0-4096 characters.
     * @param array<MessageEntity>|null $text_entities Optional. Special entities that appear in text, such as usernames, URLs, bot commands, etc.
     * @param Animation|null $animation Optional. Animation that will be displayed in the game message in chats. Upload via BotFather
     */
    public function __construct(
        public string $title,
        public string $description,
        public array $photo,
        public ?string $text = null,
        public ?array $text_entities = null,
        public ?Animation $animation = null,
    ) {}
}
