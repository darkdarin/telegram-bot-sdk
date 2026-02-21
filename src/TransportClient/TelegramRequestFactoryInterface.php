<?php

namespace DarkDarin\TelegramBotSdk\TransportClient;

use Argo\RestClient\RestRequestFactoryInterface;

interface TelegramRequestFactoryInterface extends RestRequestFactoryInterface
{
    public function setToken(string $token): void;
}
