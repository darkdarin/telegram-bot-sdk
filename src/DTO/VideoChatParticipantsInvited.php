<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a service message about new members invited to a video chat.
 *
 * @link https://core.telegram.org/bots/api#videochatparticipantsinvited
 */
readonly class VideoChatParticipantsInvited
{
    /**
     * @param array<User> $users New members that were invited to the video chat
     */
    public function __construct(
        public array $users,
    ) {}
}
