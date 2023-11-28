<?php

namespace DarkDarin\TelegramBotSdk\DTO;

use Carbon\Carbon;

/**
 * This object contains information about a poll.
 *
 * @link https://core.telegram.org/bots/api#poll
 */
readonly class Poll
{
    /**
     * @param string $id Unique poll identifier
     * @param string $question Poll question, 1-300 characters
     * @param array<PollOption> $options List of poll options
     * @param int $total_voter_count Total number of users that voted in the poll
     * @param bool $is_closed True, if the poll is closed
     * @param bool $is_anonymous True, if the poll is anonymous
     * @param PollTypeEnum $type Poll type, currently can be “regular” or “quiz”
     * @param bool $allows_multiple_answers True, if the poll allows multiple answers
     * @param int|null $correct_option_id Optional. 0-based identifier of the correct answer option. Available only for polls in the quiz mode, which are closed, or was sent (not forwarded) by the bot or to the private chat with the bot.
     * @param string|null $explanation Optional. Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz-style poll, 0-200 characters
     * @param array<MessageEntity>|null $explanation_entities Optional. Special entities like usernames, URLs, bot commands, etc. that appear in the explanation
     * @param int|null $open_period Optional. Amount of time in seconds the poll will be active after creation
     * @param Carbon|null $close_date Optional. Point in time (Unix timestamp) when the poll will be automatically closed
     */
    public function __construct(
        public string $id,
        public string $question,
        public array $options,
        public int $total_voter_count,
        public bool $is_closed,
        public bool $is_anonymous,
        public PollTypeEnum $type,
        bool $allows_multiple_answers,
        public ?int $correct_option_id = null,
        public ?string $explanation = null,
        public ?array $explanation_entities = null,
        public ?int $open_period = null,
        public ?Carbon $close_date = null,
    ) {}
}
