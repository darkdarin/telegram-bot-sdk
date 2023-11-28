<?php

namespace DarkDarin\TelegramBotSdk\DTO;

use Symfony\Component\Serializer\Annotation\DiscriminatorMap;

#[DiscriminatorMap(typeProperty: 'status', mapping: [
    'creator' => ChatMemberOwner::class,
    'administrator' => ChatMemberAdministrator::class,
    'member' => ChatMemberMember::class,
    'restricted' => ChatMemberRestricted::class,
    'left' => ChatMemberLeft::class,
    'kicked' => ChatMemberBanned::class,
])]
abstract readonly class ChatMember
{
    /**
     * @param string $status The member's status in the chat
     * @param User $user Information about the user
     */
    public function __construct(
        public string $status,
        public User $user,
    ) {}
}
