<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * Represents a chat member that owns the chat and has all administrator privileges.
 *
 * @link https://core.telegram.org/bots/api#chatmemberowner
 */
readonly class ChatMemberOwner extends ChatMember
{
    /**
     * @param string $status The member's status in the chat, always “creator”
     * @param User $user Information about the user
     * @param bool $is_anonymous True, if the user's presence in the chat is hidden
     * @param string|null $custom_title Optional. Custom title for this user
     */
    public function __construct(
        string $status,
        User $user,
        public bool $is_anonymous,
        public ?string $custom_title,
    ) {
        parent::__construct($status, $user);
    }
}
