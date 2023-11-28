<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents information about an order.
 *
 * @link https://core.telegram.org/bots/api#orderinfo
 */
readonly class OrderInfo
{
    /**
     * @param string|null $name Optional. User name
     * @param string|null $phone_number Optional. User's phone number
     * @param string|null $email Optional. User email
     * @param ShippingAddress|null $shipping_address Optional. User shipping address
     */
    public function __construct(
        public ?string $name = null,
        public ?string $phone_number = null,
        public ?string $email = null,
        public ?ShippingAddress $shipping_address = null,
    ) {}
}
