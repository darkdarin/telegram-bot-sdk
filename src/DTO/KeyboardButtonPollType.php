<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents type of a poll, which is allowed to be created and sent when the corresponding button is pressed.
 *
 * @link https://core.telegram.org/bots/api#keyboardbuttonpolltype
 */
readonly class KeyboardButtonPollType
{
    /**
     * @param PollTypeEnum|null $type Optional. If quiz is passed, the user will be allowed to create only polls in the quiz mode. If regular is passed, only regular polls will be allowed. Otherwise, the user will be allowed to create a poll of any type.
     */
    public function __construct(
        public ?PollTypeEnum $type = null,
    ) {}
}
