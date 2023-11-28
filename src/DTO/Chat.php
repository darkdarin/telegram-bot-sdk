<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a chat.
 *
 * @link https://core.telegram.org/bots/api#chat
 */
readonly class Chat
{
    /**
     * @param int $id Unique identifier for this chat. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
     * @param ChatTypeEnum $type Type of chat, can be either “private”, “group”, “supergroup” or “channel”
     * @param string|null $title Optional. Title, for supergroups, channels and group chats
     * @param string|null $username Optional. Username, for private chats, supergroups and channels if available
     * @param string|null $first_name Optional. First name of the other party in a private chat
     * @param string|null $last_name Optional. Last name of the other party in a private chat
     * @param bool $is_forum Optional. True, if the supergroup chat is a forum (has topics enabled)
     * @param ChatPhoto|null $photo Optional. Chat photo. Returned only in getChat.
     * @param array<string>|null $active_usernames Optional. If non-empty, the list of all active chat usernames; for private chats, supergroups and channels. Returned only in getChat.
     * @param string|null $emoji_status_custom_emoji_id Optional. Custom emoji identifier of emoji status of the other party in a private chat. Returned only in getChat.
     * @param int|null $emoji_status_expiration_date Optional. Expiration date of the emoji status of the other party in a private chat in Unix time, if any. Returned only in getChat.
     * @param string|null $bio Optional. Bio of the other party in a private chat. Returned only in getChat.
     * @param bool $has_private_forwards Optional. True, if privacy settings of the other party in the private chat allows to use tg://user?id=<user_id> links only in chats with the user. Returned only in getChat.
     * @param bool $has_restricted_voice_and_video_messages Optional. True, if the privacy settings of the other party restrict sending voice and video note messages in the private chat. Returned only in getChat.
     * @param bool $join_to_send_messages Optional. True, if users need to join the supergroup before they can send messages. Returned only in getChat.
     * @param bool|null $join_by_request Optional. True, if all users directly joining the supergroup need to be approved by supergroup administrators. Returned only in getChat.
     * @param string|null $description Optional. Description, for groups, supergroups and channel chats. Returned only in getChat.
     * @param string|null $invite_link Optional. Primary invite link, for groups, supergroups and channel chats. Returned only in getChat.
     * @param Message|null $pinned_message Optional. The most recent pinned message (by sending date). Returned only in getChat.
     * @param ChatPermissions|null $permissions Optional. Default chat member permissions, for groups and supergroups. Returned only in getChat.
     * @param int|null $slow_mode_delay Optional. For supergroups, the minimum allowed delay between consecutive messages sent by each unpriviledged user; in seconds. Returned only in getChat.
     * @param int|null $message_auto_delete_time Optional. The time after which all messages sent to the chat will be automatically deleted; in seconds. Returned only in getChat.
     * @param bool $has_aggressive_anti_spam_enabled Optional. True, if aggressive anti-spam checks are enabled in the supergroup. The field is only available to chat administrators. Returned only in getChat.
     * @param bool $has_hidden_members Optional. True, if non-administrators can only get the list of bots and administrators in the chat. Returned only in getChat.
     * @param bool $has_protected_content Optional. True, if messages from the chat can't be forwarded to other chats. Returned only in getChat.
     * @param string|null $sticker_set_name Optional. For supergroups, name of group sticker set. Returned only in getChat.
     * @param bool $can_set_sticker_set Optional. True, if the bot can change the group sticker set. Returned only in getChat.
     * @param int|null $linked_chat_id Optional. Unique identifier for the linked chat, i.e. the discussion group identifier for a channel and vice versa; for supergroups and channel chats. This identifier may be greater than 32 bits and some programming languages may have difficulty/silent defects in interpreting it. But it is smaller than 52 bits, so a signed 64 bit integer or double-precision float type are safe for storing this identifier. Returned only in getChat.
     * @param ChatLocation|null $location Optional. For supergroups, the location to which the supergroup is connected. Returned only in getChat.
     */
    public function __construct(
        public int $id,
        public ChatTypeEnum $type,
        public ?string $title = null,
        public ?string $username = null,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public bool $is_forum = false,
        public ?ChatPhoto $photo = null,
        public ?array $active_usernames = null,
        public ?string $emoji_status_custom_emoji_id = null,
        public ?int $emoji_status_expiration_date = null,
        public ?string $bio = null,
        public bool $has_private_forwards = false,
        public bool $has_restricted_voice_and_video_messages = false,
        public bool $join_to_send_messages = false,
        public ?bool $join_by_request = false,
        public ?string $description = null,
        public ?string $invite_link = null,
        public ?Message $pinned_message = null,
        public ?ChatPermissions $permissions = null,
        public ?int $slow_mode_delay = null,
        public ?int $message_auto_delete_time = null,
        public bool $has_aggressive_anti_spam_enabled = false,
        public bool $has_hidden_members = false,
        public bool $has_protected_content = false,
        public ?string $sticker_set_name = null,
        public bool $can_set_sticker_set = false,
        public ?int $linked_chat_id = null,
        public ?ChatLocation $location = null,
    ) {}
}
