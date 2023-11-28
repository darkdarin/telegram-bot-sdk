<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents an incoming update.
 * At most one of the optional parameters can be present in any given update.
 *
 * @link https://core.telegram.org/bots/api#update
 */
readonly class Update
{
    /**
     * @param int $update_id The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially. This ID becomes especially handy if you're using webhooks, since it allows you to ignore repeated updates or to restore the correct update sequence, should they get out of order. If there are no new updates for at least a week, then identifier of the next update will be chosen randomly instead of sequentially.
     * @param Message|null $message Optional. New incoming message of any kind - text, photo, sticker, etc.
     * @param Message|null $edited_message Optional. New version of a message that is known to the bot and was edited
     * @param Message|null $channel_post Optional. New incoming channel post of any kind - text, photo, sticker, etc.
     * @param Message|null $edited_channel_post Optional. New version of a channel post that is known to the bot and was edited
     * @param InlineQuery|null $inline_query Optional. New incoming inline query
     * @param ChosenInlineResult|null $chosen_inline_result Optional. The result of an inline query that was chosen by a user and sent to their chat partner. Please see our documentation on the feedback collecting for details on how to enable these updates for your bot.
     * @param CallbackQuery|null $callback_query Optional. New incoming callback query
     * @param ShippingQuery|null $shipping_query Optional. New incoming shipping query. Only for invoices with flexible price
     * @param PreCheckoutQuery|null $pre_checkout_query Optional. New incoming pre-checkout query. Contains full information about checkout
     * @param Poll|null $poll Optional. New poll state. Bots receive only updates about stopped polls and polls, which are sent by the bot
     * @param PollAnswer|null $poll_answer Optional. A user changed their answer in a non-anonymous poll. Bots receive new votes only in polls that were sent by the bot itself.
     * @param ChatMemberUpdated|null $my_chat_member Optional. The bot's chat member status was updated in a chat. For private chats, this update is received only when the bot is blocked or unblocked by the user.
     * @param ChatMemberUpdated|null $chat_member Optional. A chat member's status was updated in a chat. The bot must be an administrator in the chat and must explicitly specify "chat_member" in the list of allowed_updates to receive these updates.
     * @param ChatJoinRequest|null $chat_join_request Optional. A request to join the chat has been sent. The bot must have the can_invite_users administrator right in the chat to receive these updates.
     */
    public function __construct(
        public int $update_id,
        public ?Message $message = null,
        public ?Message $edited_message = null,
        public ?Message $channel_post = null,
        public ?Message $edited_channel_post = null,
        public ?InlineQuery $inline_query = null,
        public ?ChosenInlineResult $chosen_inline_result = null,
        public ?CallbackQuery $callback_query = null,
        public ?ShippingQuery $shipping_query = null,
        public ?PreCheckoutQuery $pre_checkout_query = null,
        public ?Poll $poll = null,
        public ?PollAnswer $poll_answer = null,
        public ?ChatMemberUpdated $my_chat_member = null,
        public ?ChatMemberUpdated $chat_member = null,
        public ?ChatJoinRequest $chat_join_request = null,
    ) {}
}
