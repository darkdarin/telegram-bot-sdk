<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a shipping address.
 *
 * @link https://core.telegram.org/bots/api#shippingaddress
 */
readonly class ShippingAddress
{
    /**
     * @param string $country_code Two-letter ISO 3166-1 alpha-2 country code
     * @param string $state State, if applicable
     * @param string $city City
     * @param string $street_line1 First line for the address
     * @param string $street_line2 Second line for the address
     * @param string $post_code Address post code
     */
    public function __construct(
        public string $country_code,
        public string $state,
        public string $city,
        public string $street_line1,
        public string $street_line2,
        public string $post_code,
    ) {}
}
