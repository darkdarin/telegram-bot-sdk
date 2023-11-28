<?php

namespace DarkDarin\TelegramBotSdk\DTO;

use Carbon\Carbon;

/**
 * Represents a join request sent to a chat.
 *
 * @link https://core.telegram.org/bots/api#chatjoinrequest
 */
readonly class ChatJoinRequest
{
    /**
     * @param Chat $chat Chat to which the request was sent
     * @param User $from User that sent the join request
     * @param int $user_chat_id Identifier of a private chat with the user who sent the join request. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier. The bot can use this identifier for 5 minutes to send messages until the join request is processed, assuming no other administrator contacted the user.
     * @param Carbon $date Date the request was sent in Unix time
     * @param string|null $bio Optional. Bio of the user.
     * @param ChatInviteLink|null $invite_link Optional. Chat invite link that was used by the user to send the join request
     */
    public function __construct(
        public Chat $chat,
        public User $from,
        public int $user_chat_id,
        public Carbon $date,
        public ?string $bio = null,
        public ?ChatInviteLink $invite_link = null,
    ) {}
}
