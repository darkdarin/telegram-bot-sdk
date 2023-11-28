<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a service message about a user allowing a bot to write messages after adding it to the
 * attachment menu, launching a Web App from a link, or accepting an explicit request from a Web App sent by the method
 * requestWriteAccess.
 *
 * @link https://core.telegram.org/bots/api#writeaccessallowed
 */
readonly class WriteAccessAllowed
{
    /**
     * @param bool|null $from_request Optional. True, if the access was granted after the user accepted an explicit request from a Web App sent by the method requestWriteAccess
     * @param string|null $web_app_name Optional. Name of the Web App, if the access was granted when the Web App was launched from a link
     * @param bool|null $from_attachment_menu Optional. True, if the access was granted when the bot was added to the attachment or side menu
     */
    public function __construct(
        public ?bool $from_request = null,
        public ?string $web_app_name = null,
        public ?bool $from_attachment_menu = null,
    ) {}
}
