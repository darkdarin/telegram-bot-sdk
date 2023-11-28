<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * Represents a chat member that is under certain restrictions in the chat. Supergroups only.
 *
 * @link https://core.telegram.org/bots/api#chatmemberrestricted
 */
readonly class ChatMemberRestricted extends ChatMember
{
    /**
     * @param string $status The member's status in the chat, always “restricted”
     * @param User $user Information about the user
     * @param bool $is_member True, if the user is a member of the chat at the moment of the request
     * @param bool $can_send_messages True, if the user is allowed to send text messages, contacts, invoices, locations and venues
     * @param bool $can_send_audios True, if the user is allowed to send audios
     * @param bool $can_send_documents True, if the user is allowed to send documents
     * @param bool $can_send_photos True, if the user is allowed to send photos
     * @param bool $can_send_videos True, if the user is allowed to send videos
     * @param bool $can_send_video_notes True, if the user is allowed to send video notes
     * @param bool $can_send_voice_notes True, if the user is allowed to send voice notes
     * @param bool $can_send_polls True, if the user is allowed to send polls
     * @param bool $can_send_other_messages True, if the user is allowed to send animations, games, stickers and use inline bots
     * @param bool $can_add_web_page_previews True, if the user is allowed to add web page previews to their messages
     * @param bool $can_change_info True, if the user is allowed to change the chat title, photo and other settings
     * @param bool $can_invite_users True, if the user is allowed to invite new users to the chat
     * @param bool $can_pin_messages True, if the user is allowed to pin messages
     * @param bool $can_manage_topics True, if the user is allowed to create forum topics
     * @param int $until_date Date when restrictions will be lifted for this user; Unix time. If 0, then the user is restricted forever
     */
    public function __construct(
        string $status,
        User $user,
        public bool $is_member,
        public bool $can_send_messages,
        public bool $can_send_audios,
        public bool $can_send_documents,
        public bool $can_send_photos,
        public bool $can_send_videos,
        public bool $can_send_video_notes,
        public bool $can_send_voice_notes,
        public bool $can_send_polls,
        public bool $can_send_other_messages,
        public bool $can_add_web_page_previews,
        public bool $can_change_info,
        public bool $can_invite_users,
        public bool $can_pin_messages,
        public bool $can_manage_topics,
        public int $until_date,
    ) {
        parent::__construct($status, $user);
    }
}
