<?php

namespace DarkDarin\TelegramBotSdk\DTO;

/**
 * This object represents a venue.
 *
 * @link https://core.telegram.org/bots/api#venue
 */
readonly class Venue
{
    /**
     * @param Location $location Venue location. Can't be a live location
     * @param string $title Name of the venue
     * @param string $address Address of the venue
     * @param string|null $foursquare_id Optional. Foursquare identifier of the venue
     * @param string|null $foursquare_type Optional. Foursquare type of the venue. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
     * @param string|null $google_place_id Optional. Google Places identifier of the venue
     * @param string|null $google_place_type Optional. Google Places type of the venue. (https://developers.google.com/places/web-service/supported_types)
     */
    public function __construct(
        public Location $location,
        public string $title,
        public string $address,
        public ?string $foursquare_id = null,
        public ?string $foursquare_type = null,
        public ?string $google_place_id = null,
        public ?string $google_place_type = null,
    ) {}
}
