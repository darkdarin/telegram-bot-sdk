<?php

namespace DarkDarin\TelegramBotSdk\Factories;

use Psr\Http\Message\StreamFactoryInterface;
use PsrDiscovery\Discover;
use PsrDiscovery\Exceptions\SupportPackageNotFoundException;

class PsrStreamFactoryFactory
{
    /**
     * @throws SupportPackageNotFoundException
     */
    public function __invoke(): StreamFactoryInterface
    {
        return Discover::httpStreamFactory();
    }
}
