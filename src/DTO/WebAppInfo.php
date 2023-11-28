<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * Describes a Web App.
 *
 * @link https://core.telegram.org/bots/api#webappinfo
 */
readonly class WebAppInfo
{
    /**
     * @param string $url An HTTPS URL of a Web App to be opened with additional data as specified in Initializing Web Apps
     */
    public function __construct(
        public string $url,
    ) {}
}
