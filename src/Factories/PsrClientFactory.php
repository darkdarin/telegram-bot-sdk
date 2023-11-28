<?php

namespace DarkDarin\TelegramBotSdk\Factories;

use Psr\Http\Client\ClientInterface;
use PsrDiscovery\Discover;
use PsrDiscovery\Exceptions\SupportPackageNotFoundException;

class PsrClientFactory
{
    /**
     * @throws SupportPackageNotFoundException
     */
    public function __invoke(): ClientInterface
    {
        return Discover::httpClient();
    }
}
