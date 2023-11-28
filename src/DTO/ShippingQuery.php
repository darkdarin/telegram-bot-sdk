<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object contains information about an incoming shipping query.
 *
 * @link https://core.telegram.org/bots/api#shippingquery
 */
readonly class ShippingQuery
{
    /**
     * @param string $id Unique query identifier
     * @param User $from User who sent the query
     * @param string $invoice_payload Bot specified invoice payload
     * @param ShippingAddress $shipping_address User specified shipping address
     */
    public function __construct(
        public string $id,
        public User $from,
        public string $invoice_payload,
        public ShippingAddress $shipping_address,
    ) {}
}
