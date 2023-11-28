<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * Represents a chat member that isn't currently a member of the chat, but may join it themselves.
 *
 * @link https://core.telegram.org/bots/api#chatmemberleft
 */
readonly class ChatMemberLeft extends ChatMember
{
    /**
     * @param string $status The member's status in the chat, always “left”
     * @param User $user Information about the user
     */
    public function __construct(
        string $status,
        User $user,
    ) {
        parent::__construct($status, $user);
    }
}
