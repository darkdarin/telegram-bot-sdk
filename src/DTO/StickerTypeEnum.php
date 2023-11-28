<?php

namespace DarkDarin\TelegramBotSdk\DTO;

enum StickerTypeEnum: string
{
    case Regular = 'regular';
    case Mask = 'mask';
    case CustomEmoji = 'custom_emoji';
}
