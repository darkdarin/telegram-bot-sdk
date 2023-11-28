<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * Represents a chat member that has no additional privileges or restrictions.
 *
 * @link https://core.telegram.org/bots/api#chatmembermember
 */
readonly class ChatMemberMember extends ChatMember
{
    /**
     * @param string $status The member's status in the chat, always “member”
     * @param User $user Information about the user
     */
    public function __construct(
        string $status,
        User $user,
    ) {
        parent::__construct($status, $user);
    }
}
