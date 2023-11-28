<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object contains information about one answer option in a poll.
 *
 * @link https://core.telegram.org/bots/api#polloption
 */
readonly class PollOption
{
    /**
     * @param string $text Option text, 1-100 characters
     * @param int $voter_count Number of users that voted for this option
     */
    public function __construct(
        public string $text,
        public int $voter_count,
    ) {}
}
