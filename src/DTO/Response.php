<?php

namespace DarkDarin\TelegramBotSdk\DTO;

readonly class Response
{
    public function __construct(
        public bool $ok,
        public mixed $result = null,
        public ?int $error_code = null,
        public ?string $description = null,
    ) {}
}
