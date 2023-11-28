<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object contains information about an incoming pre-checkout query.
 *
 * @link https://core.telegram.org/bots/api#precheckoutquery
 */
readonly class PreCheckoutQuery
{
    /**
     * @param string $id Unique query identifier
     * @param User $from User who sent the query
     * @param string $currency Three-letter ISO 4217 currency code
     * @param int $total_amount Total price in the smallest units of the currency (integer, not float/double). For example, for a price of US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies).
     * @param string $invoice_payload Bot specified invoice payload
     * @param string|null $shipping_option_id Optional. Identifier of the shipping option chosen by the user
     * @param OrderInfo|null $order_info Optional. Order information provided by the user
     */
    public function __construct(
        public string $id,
        public User $from,
        public string $currency,
        public int $total_amount,
        public string $invoice_payload,
        public ?string $shipping_option_id = null,
        public ?OrderInfo $order_info = null,
    ) {}
}
