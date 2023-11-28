<?php

namespace DarkDarin\TelegramBotSdk\DTO;

use Carbon\Carbon;

/**
 * This object represents changes in the status of a chat member.
 *
 * @link https://core.telegram.org/bots/api#chatmemberupdated
 */
readonly class ChatMemberUpdated
{
    /**
     * @param Chat $chat Chat the user belongs to
     * @param User $from Performer of the action, which resulted in the change
     * @param Carbon $date Date the change was done in Unix time
     * @param ChatMember $old_chat_member Previous information about the chat member
     * @param ChatMember $new_chat_member New information about the chat member
     * @param ChatInviteLink|null $invite_link Optional. Chat invite link, which was used by the user to join the chat; for joining by invite link events only.
     * @param bool $via_chat_folder_invite_link Optional. True, if the user joined the chat via a chat folder invite link
     */
    public function __construct(
        public Chat $chat,
        public User $from,
        public Carbon $date,
        public ChatMember $old_chat_member,
        public ChatMember $new_chat_member,
        public ?ChatInviteLink $invite_link = null,
        bool $via_chat_folder_invite_link = false,
    ) {}
}
