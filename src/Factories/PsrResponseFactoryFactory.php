<?php

namespace DarkDarin\TelegramBotSdk\Factories;

use Psr\Http\Message\ResponseFactoryInterface;
use PsrDiscovery\Discover;
use PsrDiscovery\Exceptions\SupportPackageNotFoundException;

class PsrResponseFactoryFactory
{
    /**
     * @throws SupportPackageNotFoundException
     */
    public function __invoke(): ResponseFactoryInterface
    {
        return Discover::httpResponseFactory();
    }
}
