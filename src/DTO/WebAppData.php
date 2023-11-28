<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * Describes data sent from a Web App to the bot.
 *
 * @link https://core.telegram.org/bots/api#webappdata
 */
readonly class WebAppData
{
    /**
     * @param string $data The data. Be aware that a bad client can send arbitrary data in this field.
     * @param string $button_text Text of the web_app keyboard button from which the Web App was opened. Be aware that a bad client can send arbitrary data in this field.
     */
    public function __construct(
        public string $data,
        public string $button_text,
    ) {}
}
