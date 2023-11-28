<?php

namespace DarkDarin\TelegramBotSdk\DTO;

enum ChatTypeEnum: string
{
    case Sender = 'sender';
    case Private = 'private';
    case Group = 'group';
    case Supergroup = 'supergroup';
    case Channel = 'channel';
}
