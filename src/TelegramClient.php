<?php

namespace DarkDarin\TelegramBotSdk;

use DarkDarin\Serializer\ApiSerializer\ApiSerializerInterface;
use DarkDarin\TelegramBotSdk\Commands\CommandHandlerInterface;
use DarkDarin\TelegramBotSdk\DTO\ChatActionEnum;
use DarkDarin\TelegramBotSdk\DTO\DiceEmojiEnum;
use DarkDarin\TelegramBotSdk\DTO\ForceReply;
use DarkDarin\TelegramBotSdk\DTO\InlineKeyboardMarkup;
use DarkDarin\TelegramBotSdk\DTO\InputMediaAudio;
use DarkDarin\TelegramBotSdk\DTO\InputMediaDocument;
use DarkDarin\TelegramBotSdk\DTO\InputMediaPhoto;
use DarkDarin\TelegramBotSdk\DTO\InputMediaVideo;
use DarkDarin\TelegramBotSdk\DTO\Message;
use DarkDarin\TelegramBotSdk\DTO\MessageEntity;
use DarkDarin\TelegramBotSdk\DTO\MessageId;
use DarkDarin\TelegramBotSdk\DTO\ParseModeEnum;
use DarkDarin\TelegramBotSdk\DTO\Poll;
use DarkDarin\TelegramBotSdk\DTO\PollTypeEnum;
use DarkDarin\TelegramBotSdk\DTO\ReplyKeyboardMarkup;
use DarkDarin\TelegramBotSdk\DTO\ReplyKeyboardRemove;
use DarkDarin\TelegramBotSdk\DTO\Update;
use DarkDarin\TelegramBotSdk\DTO\UpdateTypeEnum;
use DarkDarin\TelegramBotSdk\DTO\User;
use DarkDarin\TelegramBotSdk\DTO\WebhookInfo;
use DarkDarin\TelegramBotSdk\Exceptions\TelegramException;
use DarkDarin\TelegramBotSdk\TransportClient\TransportClientInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @psalm-api
 */
readonly class TelegramClient
{
    public function __construct(
        private string $botName,
        private string $token,
        private TransportClientInterface $client,
        private ApiSerializerInterface $serializer,
        private CommandHandlerInterface $commandHandler,
    ) {}

    public function getWebhookUpdate(string $requestBody): Update
    {
        try {
            return $this->serializer->deserialize($requestBody, Update::class, 'json');
        } catch (TelegramException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new TelegramException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function handleCommands(Update|Message $update): void
    {
        if ($update instanceof Update) {
            $message = $update->message;
        } else {
            $message = $update;
        }

        if ($message !== null) {
            $this->commandHandler->handle($this->botName, $message);
        }
    }

    public function toArray(object $object): array
    {
        try {
            return $this->serializer->normalize($object);
        } catch (TelegramException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new TelegramException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Use this method to receive incoming updates using long polling (wiki).
     *
     * @link https://core.telegram.org/bots/api#getupdates
     *
     * @param int|null $offset Identifier of the first update to be returned. Must be greater by one than the highest among the identifiers of previously received updates.
     * @param int|null $limit Limits the number of updates to be retrieved. Values between 1-100 are accepted. Defaults to 100.
     * @param int|null $timeout Timeout in seconds for long polling. Defaults to 0, i.e. usual short polling. Should be positive, short polling should be used for testing purposes only.
     * @param array<UpdateTypeEnum> $allowed_updates List of the update types you want your bot to receive
     * @return array<Update>
     */
    public function getUpdates(
        ?int $offset = null,
        ?int $limit = null,
        ?int $timeout = null,
        array $allowed_updates = [],
    ): array {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Update::class . '[]');
    }

    /**
     * Use this method to specify a URL and receive incoming updates via an outgoing webhook. Whenever there is an
     * update for the bot, we will send an HTTPS POST request to the specified URL, containing a JSON-serialized Update.
     * In case of an unsuccessful request, we will give up after a reasonable amount of attempts.
     *
     * If you'd like to make sure that the webhook was set by you, you can specify secret data in the parameter secret_token.
     * If specified, the request will contain a header “X-Telegram-Bot-Api-Secret-Token” with the secret token as content.
     *
     * @link https://core.telegram.org/bots/api#setwebhook
     *
     * @param string $url HTTPS URL to send updates to. Use an empty string to remove webhook integration
     * @param string|StreamInterface|null $certificate Upload your public key certificate so that the root certificate in use can be checked. See our self-signed guide for details.
     * @param string|null $ip_address The fixed IP address which will be used to send webhook requests instead of the IP address resolved through DNS
     * @param int|null $max_connections The maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery, 1-100. Defaults to 40. Use lower values to limit the load on your bot's server, and higher values to increase your bot's throughput.
     * @param array<UpdateTypeEnum>|null $allowed_updates A JSON-serialized list of the update types you want your bot to receive
     * @param bool|null $drop_pending_updates Pass True to drop all pending updates
     * @param string|null $secret_token A secret token to be sent in a header “X-Telegram-Bot-Api-Secret-Token” in every webhook request, 1-256 characters. Only characters A-Z, a-z, 0-9, _ and - are allowed. The header is useful to ensure that the request comes from a webhook set by you.
     * @return bool True on success.
     */
    public function setWebhook(
        string $url,
        string|StreamInterface|null $certificate = null,
        ?string $ip_address = null,
        ?int $max_connections = null,
        ?array $allowed_updates = null,
        ?bool $drop_pending_updates = null,
        ?string $secret_token = null,
    ): bool {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), multipartField: 'certificate');
    }

    /**
     * Use this method to remove webhook integration if you decide to switch back to getUpdates. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#deletewebhook
     *
     * @param bool|null $drop_pending_updates Pass True to drop all pending updates
     * @return bool
     */
    public function deleteWebhook(?bool $drop_pending_updates = null): bool
    {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args());
    }

    /**
     * Use this method to get current webhook status. Requires no parameters. On success, returns a WebhookInfo object.
     * If the bot is using getUpdates, will return an object with the url field empty.
     *
     * @link https://core.telegram.org/bots/api#getwebhookinfo
     */
    public function getWebhookInfo(): WebhookInfo
    {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), WebhookInfo::class);
    }

    /**
     * A simple method for testing your bot's authentication token
     *
     * @link https://core.telegram.org/bots/api#getme
     */
    public function getMe(): User
    {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), User::class);
    }

    /**
     * Use this method to send text messages
     *
     * @link https://core.telegram.org/bots/api#sendmessage
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $text Text of the message to be sent, 1-4096 characters after entities parsing
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the message text
     * @param array<MessageEntity>|null $entities List of special entities that appear in message text, which can be specified instead of parse_mode
     * @param bool|null $disable_web_page_preview Disables link previews for links in this message
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return Message
     */
    public function sendMessage(
        int|string $chat_id,
        string $text,
        ?int $message_thread_id = null,
        ?ParseModeEnum $parse_mode = null,
        ?array $entities = null,
        ?bool $disable_web_page_preview = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class);
    }

    /**
     * Use this method to forward messages of any kind. Service messages can't be forwarded
     *
     * @link https://core.telegram.org/bots/api#forwardmessage
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|string $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format @channelusername)
     * @param int $message_id Message identifier in the chat specified in from_chat_id
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the forwarded message from forwarding and saving
     * @return Message
     */
    public function forwardMessage(
        int|string $chat_id,
        int|string $from_chat_id,
        int $message_id,
        ?int $message_thread_id = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class);
    }

    /**
     * Use this method to copy messages of any kind. Service messages and invoice messages can't be copied. A quiz poll
     * can be copied only if the value of the field correct_option_id is known to the bot. The method is analogous
     * to the method forwardMessage, but the copied message doesn't have a link to the original message
     *
     * @link https://core.telegram.org/bots/api#copymessage
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|string $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format @channelusername)
     * @param int $message_id Message identifier in the chat specified in from_chat_id
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $caption New caption for media, 0-1024 characters after entities parsing. If not specified, the original caption is kept
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the new caption
     * @param array<MessageEntity>|null $caption_entities List of special entities that appear in the new caption, which can be specified instead of parse_mode
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return MessageId
     */
    public function copyMessage(
        int|string $chat_id,
        int|string $from_chat_id,
        int $message_id,
        ?int $message_thread_id = null,
        ?string $caption = null,
        ?ParseModeEnum $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): MessageId {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), MessageId::class);
    }

    /**
     * Use this method to send photos.
     * On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendphoto
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param StreamInterface|string $photo Photo to send. Pass a file_id as String to send a photo that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a photo from the Internet, or upload a new photo
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $caption Photo caption (may also be used when resending photos by file_id), 0-1024 characters after entities parsing
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the photo caption
     * @param array<MessageEntity>|null $caption_entities List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $has_spoiler Pass True if the photo needs to be covered with a spoiler animation
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return Message
     */
    public function sendPhoto(
        int|string $chat_id,
        StreamInterface|string $photo,
        ?int $message_thread_id = null,
        ?string $caption = null,
        ?ParseModeEnum $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $has_spoiler = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class, 'photo');
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display them in the music player.
     * Your audio must be in the .MP3 or .M4A format.
     * On success, the sent Message is returned.
     * Bots can currently send audio files of up to 50 MB in size, this limit may be changed in the future.
     *
     * @link https://core.telegram.org/bots/api#sendaudio
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param StreamInterface|string $audio Audio file to send. Pass a file_id as String to send an audio file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get an audio file from the Internet, or upload a new one
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $caption Audio caption, 0-1024 characters after entities parsing
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the audio caption
     * @param array<MessageEntity>|null $caption_entities List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param int|null $duration Duration of the audio in seconds
     * @param string|null $performer Performer
     * @param string|null $title Track name
     * @param StreamInterface|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Thumbnails can't be reused and can be only uploaded as a new file
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return Message
     */
    public function sendAudio(
        int|string $chat_id,
        StreamInterface|string $audio,
        ?int $message_thread_id = null,
        ?string $caption = null,
        ?ParseModeEnum $parse_mode = null,
        ?array $caption_entities = null,
        ?int $duration = null,
        ?string $performer = null,
        ?string $title = null,
        StreamInterface|string|null $thumbnail = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class, 'audio');
    }

    /**
     * Use this method to send general files.
     * On success, the sent Message is returned.
     * Bots can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.
     *
     * @link https://core.telegram.org/bots/api#senddocument
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param StreamInterface|string $document File to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param StreamInterface|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Thumbnails can't be reused and can be only uploaded as a new file
     * @param string|null $caption Document caption (may also be used when resending documents by file_id), 0-1024 characters after entities parsing
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the document caption
     * @param array<MessageEntity>|null $caption_entities List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $disable_content_type_detection Disables automatic server-side content type detection for files uploaded using multipart/form-data
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return Message
     */
    public function sendDocument(
        int|string $chat_id,
        StreamInterface|string $document,
        ?int $message_thread_id = null,
        StreamInterface|string|null $thumbnail = null,
        ?string $caption = null,
        ?ParseModeEnum $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $disable_content_type_detection = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class, 'document');
    }

    /**
     * Use this method to send video files, Telegram clients support MPEG4 videos (other formats may be sent as Document).
     * On success, the sent Message is returned.
     * Bots can currently send video files of up to 50 MB in size, this limit may be changed in the future.
     *
     * @link https://core.telegram.org/bots/api#sendvideo
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param StreamInterface|string $video Video to send. Pass a file_id as String to send a video that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a video from the Internet, or upload a new video
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $duration Duration of sent video in seconds
     * @param int|null $width Video width
     * @param int|null $height Video height
     * @param StreamInterface|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Thumbnails can't be reused and can be only uploaded as a new file
     * @param string|null $caption Video caption (may also be used when resending videos by file_id), 0-1024 characters after entities parsing
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the video caption
     * @param array<MessageEntity>|null $caption_entities List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $has_spoiler Pass True if the video needs to be covered with a spoiler animation
     * @param bool|null $supports_streaming Pass True if the uploaded video is suitable for streaming
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return Message
     */
    public function sendVideo(
        int|string $chat_id,
        StreamInterface|string $video,
        ?int $message_thread_id = null,
        ?int $duration = null,
        ?int $width = null,
        ?int $height = null,
        StreamInterface|string|null $thumbnail = null,
        ?string $caption = null,
        ?ParseModeEnum $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $has_spoiler = null,
        ?bool $supports_streaming = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class, 'video');
    }

    /**
     * Use this method to send animation files (GIF or H.264/MPEG-4 AVC video without sound).
     * On success, the sent Message is returned.
     * Bots can currently send animation files of up to 50 MB in size, this limit may be changed in the future.
     *
     * @link https://core.telegram.org/bots/api#sendanimation
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param StreamInterface|string $animation Animation to send. Pass a file_id as String to send an animation that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get an animation from the Internet, or upload a new animation
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $duration Duration of sent animation in seconds
     * @param int|null $width Animation width
     * @param int|null $height Animation height
     * @param StreamInterface|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file
     * @param string|null $caption Animation caption (may also be used when resending animation by file_id), 0-1024 characters after entities parsing
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the animation caption
     * @param array<MessageEntity>|null $caption_entities List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $has_spoiler Pass True if the animation needs to be covered with a spoiler animation
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return Message
     */
    public function sendAnimation(
        int|string $chat_id,
        StreamInterface|string $animation,
        ?int $message_thread_id = null,
        ?int $duration = null,
        ?int $width = null,
        ?int $height = null,
        StreamInterface|string|null $thumbnail = null,
        ?string $caption = null,
        ?ParseModeEnum $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $has_spoiler = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class, 'animation');
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display the file as a playable voice message.
     * For this to work, your audio must be in an .OGG file encoded with OPUS (other formats may be sent as Audio or Document).
     * On success, the sent Message is returned.
     * Bots can currently send voice messages of up to 50 MB in size, this limit may be changed in the future.
     *
     * @link https://core.telegram.org/bots/api#sendvoice
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param StreamInterface|string $voice Audio file to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $caption Voice message caption, 0-1024 characters after entities parsing
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the voice message caption
     * @param array<MessageEntity>|null $caption_entities List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param int|null $duration Duration of the voice message in seconds
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return Message
     */
    public function sendVoice(
        int|string $chat_id,
        StreamInterface|string $voice,
        ?int $message_thread_id = null,
        ?string $caption = null,
        ?ParseModeEnum $parse_mode = null,
        ?array $caption_entities = null,
        ?int $duration = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class, 'voice');
    }

    /**
     * As of v.4.0, Telegram clients support rounded square MPEG4 videos of up to 1 minute long.
     * Use this method to send video messages.
     * On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendvideonote
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param StreamInterface|string $video_note Video note to send. Pass a file_id as String to send a video note that exists on the Telegram servers (recommended) or upload a new video. Sending video notes by a URL is currently unsupported
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $duration Duration of sent video in seconds
     * @param int|null $length Video width and height, i.e. diameter of the video message
     * @param StreamInterface|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return Message
     */
    public function sendVideoNote(
        int|string $chat_id,
        StreamInterface|string $video_note,
        ?int $message_thread_id = null,
        ?int $duration = null,
        ?int $length = null,
        StreamInterface|string|null $thumbnail = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class, 'video_note');
    }

    /**
     * Use this method to send a group of photos, videos, documents or audios as an album.
     * Documents and audio files can be only grouped in an album with messages of the same type.
     * On success, an array of Messages that were sent is returned.
     *
     * @link https://core.telegram.org/bots/api#sendmediagroup
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param array<InputMediaAudio|InputMediaDocument|InputMediaPhoto|InputMediaVideo> $media Array describing messages to be sent, must include 2-10 items
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param bool|null $disable_notification Sends messages silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent messages from forwarding and saving
     * @param int|null $reply_to_message_id If the messages are a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @return array<Message>
     */
    public function sendMediaGroup(
        int|string $chat_id,
        array $media,
        ?int $message_thread_id = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
    ): array {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class . '[]', true);
    }

    /**
     * Use this method to send point on the map.
     * On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendlocation
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param float $latitude Latitude of the location
     * @param float $longitude Longitude of the location
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param float|null $horizontal_accuracy The radius of uncertainty for the location, measured in meters; 0-1500
     * @param int|null $live_period Period in seconds for which the location will be updated (see Live Locations, should be between 60 and 86400.
     * @param int|null $heading For live locations, a direction in which the user is moving, in degrees. Must be between 1 and 360 if specified.
     * @param int|null $proximity_alert_radius For live locations, a maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified.
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return Message
     */
    public function sendLocation(
        int|string $chat_id,
        float $latitude,
        float $longitude,
        ?int $message_thread_id = null,
        ?float $horizontal_accuracy = null,
        ?int $live_period = null,
        ?int $heading = null,
        ?int $proximity_alert_radius = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class);
    }

    /**
     * Use this method to send information about a venue.
     * On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendvenue
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param float $latitude Latitude of the venue
     * @param float $longitude Longitude of the venue
     * @param string $title Name of the venue
     * @param string $address Address of the venue
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $foursquare_id Foursquare identifier of the venue
     * @param string|null $foursquare_type Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
     * @param string|null $google_place_id Google Places identifier of the venue
     * @param string|null $google_place_type Google Places type of the venue. (See supported types https://developers.google.com/places/web-service/supported_types)
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return Message
     */
    public function sendVenue(
        int|string $chat_id,
        float $latitude,
        float $longitude,
        string $title,
        string $address,
        ?int $message_thread_id = null,
        ?string $foursquare_id = null,
        ?string $foursquare_type = null,
        ?string $google_place_id = null,
        ?string $google_place_type = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class);
    }

    /**
     * Use this method to send phone contacts.
     * On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendcontact
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $phone_number Contact's phone number
     * @param string $first_name Contact's first name
     * @param string|null $last_name Contact's last name
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $vcard Additional data about the contact in the form of a vCard, 0-2048 bytes (https://en.wikipedia.org/wiki/VCard)
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return Message
     */
    public function sendContact(
        int|string $chat_id,
        string $phone_number,
        string $first_name,
        ?string $last_name = null,
        ?int $message_thread_id = null,
        ?string $vcard = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class);
    }

    /**
     * Use this method to send a native poll.
     * On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendpoll
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $question Poll question, 1-300 characters
     * @param array $options List of answer options, 2-10 strings 1-100 characters each
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param bool|null $is_anonymous True, if the poll needs to be anonymous, defaults to True
     * @param PollTypeEnum|null $type Poll type, “quiz” or “regular”, defaults to “regular”
     * @param bool|null $allows_multiple_answers True, if the poll allows multiple answers, ignored for polls in quiz mode, defaults to False
     * @param int|null $correct_option_id 0-based identifier of the correct answer option, required for polls in quiz mode
     * @param string|null $explanation Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz-style poll, 0-200 characters with at most 2 line feeds after entities parsing
     * @param ParseModeEnum|null $explanation_parse_mode Mode for parsing entities in the explanation
     * @param array<MessageEntity>|null $explanation_entities List of special entities that appear in the poll explanation, which can be specified instead of parse_mode
     * @param int|null $open_period Amount of time in seconds the poll will be active after creation, 5-600. Can't be used together with close_date.
     * @param int|null $close_date Point in time (Unix timestamp) when the poll will be automatically closed. Must be at least 5 and no more than 600 seconds in the future. Can't be used together with open_period.
     * @param bool|null $is_closed Pass True if the poll needs to be immediately closed. This can be useful for poll preview.
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return Message
     */
    public function sendPoll(
        int|string $chat_id,
        string $question,
        array $options,
        ?int $message_thread_id = null,
        ?bool $is_anonymous = null,
        ?PollTypeEnum $type = null,
        ?bool $allows_multiple_answers = null,
        ?int $correct_option_id = null,
        ?string $explanation = null,
        ?ParseModeEnum $explanation_parse_mode = null,
        ?array $explanation_entities = null,
        ?int $open_period = null,
        ?int $close_date = null,
        ?bool $is_closed = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class);
    }

    /**
     * Use this method to send an animated emoji that will display a random value.
     * On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#senddice
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param DiceEmojiEnum|null $emoji Emoji on which the dice throw animation is based. Currently, must be one of “🎲”, “🎯”, “🏀”, “⚽”, “🎳”, or “🎰”. Dice can have values 1-6 for “🎲”, “🎯” and “🎳”, values 1-5 for “🏀” and “⚽”, and values 1-64 for “🎰”. Defaults to “🎲”
     * @param bool|null $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options
     * @return Message
     */
    public function sendDice(
        int|string $chat_id,
        ?int $message_thread_id = null,
        ?DiceEmojiEnum $emoji = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): Message {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class);
    }

    /**
     * Use this method when you need to tell the user that something is happening on the bot's side.
     * The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing status).
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#sendchataction
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param ChatActionEnum $action Type of action to broadcast
     * @param int|null $message_thread_id Unique identifier for the target message thread; supergroups only
     * @return bool
     */
    public function sendChatAction(
        int|string $chat_id,
        ChatActionEnum $action,
        ?int $message_thread_id = null,
    ): bool {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args());
    }

    /**
     * Use this method to edit text and game messages.
     * On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
     *
     * @link https://core.telegram.org/bots/api#editmessagetext
     *
     * @param string $text New text of the message, 1-4096 characters after entities parsing
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the message text. See formatting options for more details.
     * @param array<MessageEntity>|null $entities List of special entities that appear in message text, which can be specified instead of parse_mode
     * @param bool|null $disable_web_page_preview Disables link previews for links in this message
     * @param InlineKeyboardMarkup|null $reply_markup Object for an inline keyboard
     * @return Message|bool
     */
    public function editMessageText(
        string $text,
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?ParseModeEnum $parse_mode = null,
        ?array $entities = null,
        ?bool $disable_web_page_preview = null,
        ?InlineKeyboardMarkup $reply_markup = null,
    ): Message|bool {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class);
    }

    /**
     * Use this method to edit captions of messages.
     * On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
     *
     * @link https://core.telegram.org/bots/api#editmessagecaption
     *
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param string|null $caption New caption of the message, 0-1024 characters after entities parsing
     * @param ParseModeEnum|null $parse_mode Mode for parsing entities in the message caption
     * @param array|null $caption_entities List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param InlineKeyboardMarkup|null $reply_markup Object for an inline keyboard.
     * @return Message|bool
     */
    public function editMessageCaption(
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?string $caption = null,
        ?ParseModeEnum $parse_mode = null,
        ?array $caption_entities = null,
        ?InlineKeyboardMarkup $reply_markup = null,
    ): Message|bool {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class);
    }

    /**
     * Use this method to edit live location messages.
     * A location can be edited until its live_period expires or editing is explicitly disabled by a call to stopMessageLiveLocation.
     * On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
     *
     * @link https://core.telegram.org/bots/api#editmessagelivelocation
     *
     * @param float $latitude Latitude of new location
     * @param float $longitude Longitude of new location
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param float|null $horizontal_accuracy The radius of uncertainty for the location, measured in meters; 0-1500
     * @param int|null $heading Direction in which the user is moving, in degrees. Must be between 1 and 360 if specified.
     * @param int|null $proximity_alert_radius The maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified.
     * @param InlineKeyboardMarkup|null $reply_markup Object for a new inline keyboard
     * @return Message|bool
     */
    public function editMessageLiveLocation(
        float $latitude,
        float $longitude,
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?float $horizontal_accuracy = null,
        ?int $heading = null,
        ?int $proximity_alert_radius = null,
        ?InlineKeyboardMarkup $reply_markup = null,
    ): Message|bool {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class);
    }

    /**
     * Use this method to stop updating a live location message before live_period expires.
     * On success, if the message is not an inline message, the edited Message is returned, otherwise True is returned.
     *
     * @link https://core.telegram.org/bots/api#stopmessagelivelocation
     *
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message with live location to stop
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param InlineKeyboardMarkup|null $reply_markup Object for a new inline keyboard
     * @return Message|bool
     */
    public function stopMessageLiveLocation(
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?InlineKeyboardMarkup $reply_markup = null,
    ): Message|bool {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class);
    }

    /**
     * Use this method to edit only the reply markup of messages.
     * On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
     *
     * @link https://core.telegram.org/bots/api#editmessagereplymarkup
     *
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param int|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param InlineKeyboardMarkup|null $reply_markup Object for an inline keyboard
     * @return Message|bool
     */
    public function editMessageReplyMarkup(
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?int $inline_message_id = null,
        ?InlineKeyboardMarkup $reply_markup = null,
    ): Message|bool {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Message::class);
    }

    /**
     * Use this method to stop a poll which was sent by the bot.
     * On success, the stopped Poll is returned.
     *
     * @link https://core.telegram.org/bots/api#stoppoll
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int $message_id Identifier of the original message with the poll
     * @param InlineKeyboardMarkup|null $reply_markup Object for a new message inline keyboard
     * @return Poll
     */
    public function stopPoll(
        int|string $chat_id,
        int $message_id,
        ?InlineKeyboardMarkup $reply_markup = null,
    ): Poll {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args(), Poll::class);
    }

    /**
     * Use this method to delete a message, including service messages, with the following limitations:
     * - A message can only be deleted if it was sent less than 48 hours ago.
     * - Service messages about a supergroup, channel, or forum topic creation can't be deleted.
     * - A dice message in a private chat can only be deleted if it was sent more than 24 hours ago.
     * - Bots can delete outgoing messages in private chats, groups, and supergroups.
     * - Bots can delete incoming messages in private chats.
     * - Bots granted can_post_messages permissions can delete outgoing messages in channels.
     * - If the bot is an administrator of a group, it can delete any message there.
     * - If the bot has can_delete_messages permission in a supergroup or a channel, it can delete any message there.
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#deletemessage
     *
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int $message_id Identifier of the message to delete
     * @return bool
     */
    public function deleteMessage(
        int|string $chat_id,
        int $message_id,
    ): bool {
        return $this->client->executeMethod($this->token, __METHOD__, func_get_args());
    }
}
