<?php

namespace DarkDarin\TelegramBotSdk\DTO;

use Carbon\Carbon;

/**
 * Represents an invite link for a chat.
 *
 * @link https://core.telegram.org/bots/api#chatinvitelink
 */
readonly class ChatInviteLink
{
    /**
     * @param string $invite_link The invite link. If the link was created by another chat administrator, then the second part of the link will be replaced with “…”.
     * @param User $creator Creator of the link
     * @param bool $creates_join_request True, if users joining the chat via the link need to be approved by chat administrators
     * @param bool $is_primary True, if the link is primary
     * @param bool $is_revoked True, if the link is revoked
     * @param string|null $name Optional. Invite link name
     * @param Carbon|null $expire_date Optional. Point in time (Unix timestamp) when the link will expire or has been expired
     * @param int|null $member_limit Optional. The maximum number of users that can be members of the chat simultaneously after joining the chat via this invite link; 1-99999
     * @param int|null $pending_join_request_count Optional. Number of pending join requests created using this link
     */
    public function __construct(
        public string $invite_link,
        public User $creator,
        public bool $creates_join_request,
        public bool $is_primary,
        public bool $is_revoked,
        public ?string $name = null,
        public ?Carbon $expire_date = null,
        public ?int $member_limit = null,
        public ?int $pending_join_request_count = null,
    ) {}
}
