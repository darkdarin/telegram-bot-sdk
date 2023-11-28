<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a custom keyboard with reply options (see Introduction to bots for details and examples).
 *
 * @link https://core.telegram.org/bots/api#replykeyboardmarkup
 */
readonly class ReplyKeyboardMarkup
{
    /**
     * @param array<array<KeyboardButton>> $keyboard Array of button rows, each represented by an Array of KeyboardButton objects
     * @param bool|null $is_persistent Optional. Requests clients to always show the keyboard when the regular keyboard is hidden. Defaults to false, in which case the custom keyboard can be hidden and opened with a keyboard icon.
     * @param bool|null $resize_keyboard Optional. Requests clients to resize the keyboard vertically for optimal fit (e.g., make the keyboard smaller if there are just two rows of buttons). Defaults to false, in which case the custom keyboard is always of the same height as the app's standard keyboard.
     * @param bool|null $one_time_keyboard Optional. Requests clients to hide the keyboard as soon as it's been used. The keyboard will still be available, but clients will automatically display the usual letter-keyboard in the chat - the user can press a special button in the input field to see the custom keyboard again. Defaults to false.
     * @param string|null $input_field_placeholder Optional. The placeholder to be shown in the input field when the keyboard is active; 1-64 characters
     * @param bool|null $selective Optional. Use this parameter if you want to show the keyboard to specific users only. Targets: 1) users that are @mentioned in the text of the Message object; 2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.
     */
    public function __construct(
        public array $keyboard,
        public ?bool $is_persistent = null,
        public ?bool $resize_keyboard = null,
        public ?bool $one_time_keyboard = null,
        public ?string $input_field_placeholder = null,
        public ?bool $selective = null,
    ) {}
}
