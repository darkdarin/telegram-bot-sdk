<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a phone contact.
 *
 * @link https://core.telegram.org/bots/api#contact
 */
readonly class Contact
{
    /**
     * @param string $phone_number Contact's phone number
     * @param string $first_name Contact's first name
     * @param string|null $last_name Optional. Contact's last name
     * @param int|null $user_id Optional. Contact's user identifier in Telegram. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
     * @param string|null $vcard Optional. Additional data about the contact in the form of a vCard
     */
    public function __construct(
        public string $phone_number,
        public string $first_name,
        public ?string $last_name = null,
        public ?int $user_id = null,
        public ?string $vcard = null,
    ) {}
}
