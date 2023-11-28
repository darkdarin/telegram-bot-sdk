<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a parameter of the inline keyboard button used to automatically authorize a user.
 * Serves as a great replacement for the Telegram Login Widget when the user is coming from Telegram.
 * All the user needs to do is tap/click a button and confirm that they want to log in.
 *
 * @link https://core.telegram.org/bots/api#loginurl
 */
readonly class LoginUrl
{
    /**
     * @param string $url An HTTPS URL to be opened with user authorization data added to the query string when the button is pressed. If the user refuses to provide authorization data, the original URL without information about the user will be opened. The data added is the same as described in Receiving authorization data.
     * @param string|null $forward_text Optional. New text of the button in forwarded messages.
     * @param string|null $bot_username Optional. Username of a bot, which will be used for user authorization. See Setting up a bot for more details. If not specified, the current bot's username will be assumed. The url's domain must be the same as the domain linked with the bot. See Linking your domain to the bot for more details.
     * @param bool|null $request_write_access Optional. Pass True to request the permission for your bot to send messages to the user.
     */
    public function __construct(
        public string $url,
        public ?string $forward_text = null,
        public ?string $bot_username = null,
        public ?bool $request_write_access = null,
    ) {}
}
