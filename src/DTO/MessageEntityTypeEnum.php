<?php

namespace DarkDarin\TelegramBotSdk\DTO;

enum MessageEntityTypeEnum: string
{
    case Mention = 'mention';
    case HashTag = 'hashtag';
    case CashTag = 'cashtag';
    case BotCommand = 'bot_command';
    case Url = 'url';
    case Email = 'email';
    case PhoneNumber = 'phone_number';
    case Bold = 'bold';
    case Italic = 'italic';
    case Underline = 'underline';
    case Strikethrough = 'strikethrough';
    case Spoiler = 'spoiler';
    case Code = 'code';
    case Pre = 'pre';
    case TextLink = 'text_link';
    case TextMention = 'text_mention';
    case CustomEmoji = 'custom_emoji';
}
