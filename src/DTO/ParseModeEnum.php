<?php

namespace DarkDarin\TelegramBotSdk\DTO;

enum ParseModeEnum: string
{
    case MarkdownV2 = 'MarkdownV2';
    case HTML = 'HTML';
    case Markdown = 'Markdown';
}
