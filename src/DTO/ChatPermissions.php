<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * Describes actions that a non-administrator user is allowed to take in a chat.
 *
 * @link https://core.telegram.org/bots/api#chatpermissions
 */
readonly class ChatPermissions
{
    /**
     * @param bool $can_send_messages Optional. True, if the user is allowed to send text messages, contacts, invoices, locations and venues
     * @param bool $can_send_audios Optional. True, if the user is allowed to send audios
     * @param bool $can_send_documents Optional. True, if the user is allowed to send documents
     * @param bool $can_send_photos Optional. True, if the user is allowed to send photos
     * @param bool $can_send_videos Optional. True, if the user is allowed to send videos
     * @param bool $can_send_video_notes Optional. True, if the user is allowed to send video notes
     * @param bool $can_send_voice_notes Optional. True, if the user is allowed to send voice notes
     * @param bool $can_send_polls Optional. True, if the user is allowed to send polls
     * @param bool $can_send_other_messages Optional. True, if the user is allowed to send animations, games, stickers and use inline bots
     * @param bool $can_add_web_page_previews Optional. True, if the user is allowed to add web page previews to their messages
     * @param bool $can_change_info Optional. True, if the user is allowed to change the chat title, photo and other settings. Ignored in public supergroups
     * @param bool $can_invite_users Optional. True, if the user is allowed to invite new users to the chat
     * @param bool $can_pin_messages Optional. True, if the user is allowed to pin messages. Ignored in public supergroups
     * @param bool $can_manage_topics Optional. True, if the user is allowed to create forum topics. If omitted defaults to the value of can_pin_messages
     */
    public function __construct(
        public bool $can_send_messages = false,
        public bool $can_send_audios = false,
        public bool $can_send_documents = false,
        public bool $can_send_photos = false,
        public bool $can_send_videos = false,
        public bool $can_send_video_notes = false,
        public bool $can_send_voice_notes = false,
        public bool $can_send_polls = false,
        public bool $can_send_other_messages = false,
        public bool $can_add_web_page_previews = false,
        public bool $can_change_info = false,
        public bool $can_invite_users = false,
        public bool $can_pin_messages = false,
        public bool $can_manage_topics = false,
    ) {}
}
