<?php

namespace DarkDarin\TelegramBotSdk\DTO;

enum PollTypeEnum: string
{
    case Quiz = 'quiz';
    case Regular = 'regular';
}
