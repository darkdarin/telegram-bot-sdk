<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object defines the criteria used to request a suitable user. The identifier of the selected user will be shared
 * with the bot when the corresponding button is pressed.
 *
 * @link https://core.telegram.org/bots/api#keyboardbuttonrequestuser
 */
readonly class KeyboardButtonRequestUser
{
    /**
     * @param int $request_id Signed 32-bit identifier of the request, which will be received back in the UserShared object. Must be unique within the message
     * @param bool|null $user_is_bot Optional. Pass True to request a bot, pass False to request a regular user. If not specified, no additional restrictions are applied.
     * @param bool|null $user_is_premium Optional. Pass True to request a premium user, pass False to request a non-premium user. If not specified, no additional restrictions are applied.
     */
    public function __construct(
        public int $request_id,
        public ?bool $user_is_bot = null,
        public ?bool $user_is_premium = null,
    ) {}
}
