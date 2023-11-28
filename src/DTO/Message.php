<?php

namespace DarkDarin\TelegramBotSdk\DTO;

use Carbon\Carbon;

/**
 * This object represents a message.
 *
 * @link https://core.telegram.org/bots/api#message
 */
readonly class Message
{
    /**
     * @param int $message_id Unique message identifier inside this chat
     * @param Carbon $date Date the message was sent in Unix time
     * @param Chat $chat Conversation the message belongs to
     * @param int|null $message_thread_id Optional. Unique identifier of a message thread to which the message belongs; for supergroups only
     * @param User|null $from Optional. Sender of the message; empty for messages sent to channels. For backward compatibility, the field contains a fake sender user in non-channel chats, if the message was sent on behalf of a chat.
     * @param Chat|null $sender_chat Optional. Sender of the message, sent on behalf of a chat. For example, the channel itself for channel posts, the supergroup itself for messages from anonymous group administrators, the linked channel for messages automatically forwarded to the discussion group. For backward compatibility, the field from contains a fake sender user in non-channel chats, if the message was sent on behalf of a chat.
     * @param User|null $forward_from Optional. For forwarded messages, sender of the original message
     * @param Chat|null $forward_from_chat Optional. For messages forwarded from channels or from anonymous administrators, information about the original sender chat
     * @param int|null $forward_from_message_id Optional. For messages forwarded from channels, identifier of the original message in the channel
     * @param string|null $forward_signature Optional. For forwarded messages that were originally sent in channels or by an anonymous chat administrator, signature of the message sender if present
     * @param string|null $forward_sender_name Optional. Sender's name for messages forwarded from users who disallow adding a link to their account in forwarded messages
     * @param int|null $forward_date Optional. For forwarded messages, date the original message was sent in Unix time
     * @param bool $is_topic_message Optional. True, if the message is sent to a forum topic
     * @param bool $is_automatic_forward Optional. True, if the message is a channel post that was automatically forwarded to the connected discussion group
     * @param Message|null $reply_to_message Optional. For replies, the original message. Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
     * @param User|null $via_bot Optional. Bot through which the message was sent
     * @param Carbon|null $edit_date Optional. Date the message was last edited in Unix time
     * @param bool $has_protected_content Optional. True, if the message can't be forwarded
     * @param string|null $media_group_id Optional. The unique identifier of a media message group this message belongs to
     * @param string|null $author_signature Optional. Signature of the post author for messages in channels, or the custom title of an anonymous group administrator
     * @param string|null $text Optional. For text messages, the actual UTF-8 text of the message
     * @param array<MessageEntity>|null $entities Optional. For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text
     * @param Animation|null $animation Optional. Message is an animation, information about the animation. For backward compatibility, when this field is set, the document field will also be set
     * @param Audio|null $audio Optional. Message is an audio file, information about the file
     * @param Document|null $document Optional. Message is a general file, information about the file
     * @param array<PhotoSize>|null $photo Optional. Message is a photo, available sizes of the photo
     * @param Sticker|null $sticker Optional. Message is a sticker, information about the sticker
     * @param Story|null $story Optional. Message is a forwarded story
     * @param Video|null $video Optional. Message is a video, information about the video
     * @param VideoNote|null $video_note Optional. Message is a video note, information about the video message
     * @param Voice|null $voice Optional. Message is a voice message, information about the file
     * @param string|null $caption Optional. Caption for the animation, audio, document, photo, video or voice
     * @param array<MessageEntity>|null $caption_entities Optional. For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption
     * @param bool $has_media_spoiler Optional. True, if the message media is covered by a spoiler animation
     * @param Contact|null $contact Optional. Message is a shared contact, information about the contact
     * @param Dice|null $dice Optional. Message is a dice with random value
     * @param Game|null $game Optional. Message is a game, information about the game. More about games »
     * @param Poll|null $poll Optional. Message is a native poll, information about the poll
     * @param Venue|null $venue Optional. Message is a venue, information about the venue. For backward compatibility, when this field is set, the location field will also be set
     * @param Location|null $location Optional. Message is a shared location, information about the location
     * @param array<User>|null $new_chat_members Optional. New members that were added to the group or supergroup and information about them (the bot itself may be one of these members)
     * @param User|null $left_chat_member Optional. A member was removed from the group, information about them (this member may be the bot itself)
     * @param string|null $new_chat_title Optional. A chat title was changed to this value
     * @param array|null $new_chat_photo Optional. A chat photo was change to this value
     * @param bool $delete_chat_photo Optional. Service message: the chat photo was deleted
     * @param bool $group_chat_created Optional. Service message: the group has been created
     * @param bool $supergroup_chat_created Optional. Service message: the supergroup has been created. This field can't be received in a message coming through updates, because bot can't be a member of a supergroup when it is created. It can only be found in reply_to_message if someone replies to a very first message in a directly created supergroup.
     * @param bool $channel_chat_created Optional. Service message: the channel has been created. This field can't be received in a message coming through updates, because bot can't be a member of a channel when it is created. It can only be found in reply_to_message if someone replies to a very first message in a channel.
     * @param MessageAutoDeleteTimerChanged|null $message_auto_delete_timer_changed Optional. Service message: auto-delete timer settings changed in the chat
     * @param int|null $migrate_to_chat_id Optional. The group has been migrated to a supergroup with the specified identifier. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
     * @param int|null $migrate_from_chat_id Optional. The supergroup has been migrated from a group with the specified identifier. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
     * @param Message|null $pinned_message Optional. Specified message was pinned. Note that the Message object in this field will not contain further reply_to_message fields even if it is itself a reply.
     * @param Invoice|null $invoice Optional. Message is an invoice for a payment, information about the invoice. More about payments »
     * @param SuccessfulPayment|null $successful_payment Optional. Message is a service message about a successful payment, information about the payment.
     * @param UserShared|null $user_shared Optional. Service message: a user was shared with the bot
     * @param ChatShared|null $chat_shared Optional. Service message: a chat was shared with the bot
     * @param string|null $connected_website Optional. The domain name of the website on which the user has logged in. More about Telegram Login »
     * @param WriteAccessAllowed|null $write_access_allowed Optional. Service message: the user allowed the bot to write messages after adding it to the attachment or side menu, launching a Web App from a link, or accepting an explicit request from a Web App sent by the method requestWriteAccess
     * @param PassportData|null $passport_data Optional. Telegram Passport data
     * @param ProximityAlertTriggered|null $proximity_alert_triggered Optional. Service message. A user in the chat triggered another user's proximity alert while sharing Live Location.
     * @param ForumTopicCreated|null $forum_topic_created Optional. Service message: forum topic created
     * @param ForumTopicEdited|null $forum_topic_edited Optional. Service message: forum topic edited
     * @param ForumTopicClosed|null $forum_topic_closed Optional. Service message: forum topic closed
     * @param ForumTopicReopened|null $forum_topic_reopened Optional. Service message: forum topic reopened
     * @param GeneralForumTopicHidden|null $general_forum_topic_hidden Optional. Service message: the 'General' forum topic hidden
     * @param GeneralForumTopicUnhidden|null $general_forum_topic_unhidden Optional. Service message: the 'General' forum topic unhidden
     * @param VideoChatScheduled|null $video_chat_scheduled Optional. Service message: video chat scheduled
     * @param VideoChatStarted|null $video_chat_started Optional. Service message: video chat started
     * @param VideoChatEnded|null $video_chat_ended Optional. Service message: video chat ended
     * @param VideoChatParticipantsInvited|null $video_chat_participants_invited Optional. Service message: new participants invited to a video chat
     * @param WebAppData|null $web_app_data Optional. Service message: data sent by a Web App
     * @param InlineKeyboardMarkup|null $reply_markup Optional. Inline keyboard attached to the message. login_url buttons are represented as ordinary url buttons.
     */
    public function __construct(
        public int $message_id,
        public Carbon $date,
        public Chat $chat,
        public ?int $message_thread_id = null,
        public ?User $from = null,
        public ?Chat $sender_chat = null,
        public ?User $forward_from = null,
        public ?Chat $forward_from_chat = null,
        public ?int $forward_from_message_id = null,
        public ?string $forward_signature = null,
        public ?string $forward_sender_name = null,
        public ?int $forward_date = null,
        public bool $is_topic_message = false,
        public bool $is_automatic_forward = false,
        public ?Message $reply_to_message = null,
        public ?User $via_bot = null,
        public ?Carbon $edit_date = null,
        public bool $has_protected_content = false,
        public ?string $media_group_id = null,
        public ?string $author_signature = null,
        public ?string $text = null,
        public ?array $entities = null,
        public ?Animation $animation = null,
        public ?Audio $audio = null,
        public ?Document $document = null,
        public ?array $photo = null,
        public ?Sticker $sticker = null,
        public ?Story $story = null,
        public ?Video $video = null,
        public ?VideoNote $video_note = null,
        public ?Voice $voice = null,
        public ?string $caption = null,
        public ?array $caption_entities = null,
        public bool $has_media_spoiler = false,
        public ?Contact $contact = null,
        public ?Dice $dice = null,
        public ?Game $game = null,
        public ?Poll $poll = null,
        public ?Venue $venue = null,
        public ?Location $location = null,
        public ?array $new_chat_members = null,
        public ?User $left_chat_member = null,
        public ?string $new_chat_title = null,
        public ?array $new_chat_photo = null,
        public bool $delete_chat_photo = false,
        public bool $group_chat_created = false,
        public bool $supergroup_chat_created = false,
        public bool $channel_chat_created = false,
        public ?MessageAutoDeleteTimerChanged $message_auto_delete_timer_changed = null,
        public ?int $migrate_to_chat_id = null,
        public ?int $migrate_from_chat_id = null,
        public ?Message $pinned_message = null,
        public ?Invoice $invoice = null,
        public ?SuccessfulPayment $successful_payment = null,
        public ?UserShared $user_shared = null,
        public ?ChatShared $chat_shared = null,
        public ?string $connected_website = null,
        public ?WriteAccessAllowed $write_access_allowed = null,
        public ?PassportData $passport_data = null,
        public ?ProximityAlertTriggered $proximity_alert_triggered = null,
        public ?ForumTopicCreated $forum_topic_created = null,
        public ?ForumTopicEdited $forum_topic_edited = null,
        public ?ForumTopicClosed $forum_topic_closed = null,
        public ?ForumTopicReopened $forum_topic_reopened = null,
        public ?GeneralForumTopicHidden $general_forum_topic_hidden = null,
        public ?GeneralForumTopicUnhidden $general_forum_topic_unhidden = null,
        public ?VideoChatScheduled $video_chat_scheduled = null,
        public ?VideoChatStarted $video_chat_started = null,
        public ?VideoChatEnded $video_chat_ended = null,
        public ?VideoChatParticipantsInvited $video_chat_participants_invited = null,
        public ?WebAppData $web_app_data = null,
        public ?InlineKeyboardMarkup $reply_markup = null,
    ) {}
}
