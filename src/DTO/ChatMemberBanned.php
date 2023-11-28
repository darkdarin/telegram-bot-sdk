<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * Represents a chat member that was banned in the chat and can't return to the chat or view chat messages.
 *
 * @link https://core.telegram.org/bots/api#chatmemberbanned
 */
readonly class ChatMemberBanned extends ChatMember
{
    /**
     * @param string $status The member's status in the chat, always “kicked”
     * @param User $user Information about the user
     * @param int $until_date Date when restrictions will be lifted for this user; Unix time. If 0, then the user is banned forever
     */
    public function __construct(
        string $status,
        User $user,
        public int $until_date,
    ) {
        parent::__construct($status, $user);
    }
}
