<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents an animated emoji that displays a random value.
 *
 * @link https://core.telegram.org/bots/api#dice
 */
readonly class Dice
{
    /**
     * @param DiceEmojiEnum $emoji Emoji on which the dice throw animation is based
     * @param int $value Value of the dice, 1-6 for “🎲”, “🎯” and “🎳” base emoji, 1-5 for “🏀” and “⚽” base emoji, 1-64 for “🎰” base emoji
     */
    public function __construct(
        public DiceEmojiEnum $emoji,
        public int $value,
    ) {}
}
