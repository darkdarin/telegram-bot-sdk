<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents an answer of a user in a non-anonymous poll.
 *
 * @link https://core.telegram.org/bots/api#pollanswer
 */
readonly class PollAnswer
{
    /**
     * @param string $poll_id Unique poll identifier
     * @param array<int> $option_ids 0-based identifiers of chosen answer options. May be empty if the vote was retracted.
     * @param Chat|null $voter_chat Optional. The chat that changed the answer to the poll, if the voter is anonymous
     * @param User|null $user 0-based identifiers of chosen answer options. May be empty if the vote was retracted.
     */
    public function __construct(
        public string $poll_id,
        public array $option_ids,
        public ?Chat $voter_chat = null,
        public ?User $user = null,
    ) {}
}
