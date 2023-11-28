<?php

namespace DarkDarin\TelegramBotSdk\Factories;

use Psr\Http\Message\RequestFactoryInterface;
use PsrDiscovery\Discover;
use PsrDiscovery\Exceptions\SupportPackageNotFoundException;

class PsrRequestFactoryFactory
{
    /**
     * @throws SupportPackageNotFoundException
     */
    public function __invoke(): RequestFactoryInterface
    {
        return Discover::httpRequestFactory();
    }
}
