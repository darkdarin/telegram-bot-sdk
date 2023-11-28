<?php

namespace DarkDarin\TelegramBotSdk\DTO;

enum UpdateTypeEnum: string
{
    case Message = 'message';
    case EditedMessage = 'edited_message';
    case ChannelPost = 'channel_post';
    case EditedChannelPost = 'edited_channel_post';
    case InlineQuery = 'inline_query';
    case ChosenInlineResult = 'chosen_inline_result';
    case CallbackQuery = 'callback_query';
    case ShippingQuery = 'shipping_query';
    case PreCheckoutQuery = 'pre_checkout_query';
    case Poll = 'poll';
    case PollAnswer = 'poll_answer';
    case MyChatMember = 'my_chat_member';
    case ChatMember = 'chat_member';
    case ChatJoinRequest = 'chat_join_request';
}
