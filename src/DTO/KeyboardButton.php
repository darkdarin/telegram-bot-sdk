<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents one button of the reply keyboard. For simple text buttons, String can be used instead of
 * this object to specify the button text.
 * The optional fields web_app, request_user, request_chat, request_contact, request_location, and request_poll
 * are mutually exclusive.
 *
 * @link https://core.telegram.org/bots/api#keyboardbutton
 */
readonly class KeyboardButton
{
    /**
     * @param string $text Text of the button. If none of the optional fields are used, it will be sent as a message when the button is pressed
     * @param KeyboardButtonRequestUser|null $request_user Optional. If specified, pressing the button will open a list of suitable users. Tapping on any user will send their identifier to the bot in a “user_shared” service message. Available in private chats only.
     * @param KeyboardButtonRequestChat|null $request_chat Optional. If specified, pressing the button will open a list of suitable chats. Tapping on a chat will send its identifier to the bot in a “chat_shared” service message. Available in private chats only.
     * @param bool|null $request_contact Optional. If True, the user's phone number will be sent as a contact when the button is pressed. Available in private chats only.
     * @param bool|null $request_location Optional. If True, the user's current location will be sent when the button is pressed. Available in private chats only.
     * @param KeyboardButtonPollType|null $request_poll Optional. If specified, the user will be asked to create a poll and send it to the bot when the button is pressed. Available in private chats only.
     * @param WebAppInfo|null $web_app Optional. If specified, the described Web App will be launched when the button is pressed. The Web App will be able to send a “web_app_data” service message. Available in private chats only.
     */
    public function __construct(
        public string $text,
        public ?KeyboardButtonRequestUser $request_user = null,
        public ?KeyboardButtonRequestChat $request_chat = null,
        public ?bool $request_contact = null,
        public ?bool $request_location = null,
        public ?KeyboardButtonPollType $request_poll = null,
        public ?WebAppInfo $web_app = null,
    ) {}
}
