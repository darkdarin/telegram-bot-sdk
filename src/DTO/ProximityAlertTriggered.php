<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents the content of a service message, sent whenever a user in the chat triggers a proximity alert set by another user.
 *
 * @link https://core.telegram.org/bots/api#proximityalerttriggered
 */
readonly class ProximityAlertTriggered
{
    /**
     * @param User $traveler User that triggered the alert
     * @param User $watcher User that set the alert
     * @param int $distance The distance between the users
     */
    public function __construct(
        public User $traveler,
        public User $watcher,
        public int $distance,
    ) {}
}
