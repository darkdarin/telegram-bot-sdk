<?php

namespace DarkDarin\TelegramBotSdk\Attribute;

#[\Attribute(\Attribute::TARGET_METHOD)]
final readonly class MultipartRequest
{
    public function __construct(
        public ?string $multipartField = null,
    ) {}
}
