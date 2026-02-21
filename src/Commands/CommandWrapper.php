<?php

namespace DarkDarin\TelegramBotSdk\Commands;

use DarkDarin\TelegramBotSdk\Commands\Attributes\Command;
use DarkDarin\TelegramBotSdk\Commands\Attributes\CommandAlias;
use DarkDarin\TelegramBotSdk\Commands\Attributes\CommandPattern;

class CommandWrapper
{
    private string $name;
    private array $aliases = [];
    private ?string $pattern = null;
    private ?string $description = null;

    public function __construct(
        private readonly object $command,
    ) {
        $this->parseCommand();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAliases(): array
    {
        return $this->aliases;
    }

    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCommand(): object
    {
        return $this->command;
    }

    private function parseCommand(): void
    {
        $reflection = new \ReflectionClass($this->command);

        $this->name = $this->command::class;

        $attributes = $reflection->getAttributes();
        foreach ($attributes as $attribute) {
            $attributeInstance = $attribute->newInstance();
            if ($attributeInstance instanceof Command) {
                $this->name = $attributeInstance->name;
                $this->description = $attributeInstance->description;
            }
            if ($attributeInstance instanceof CommandAlias) {
                $this->aliases[] = $attributeInstance->alias;
            }
            if ($attributeInstance instanceof CommandPattern) {
                $this->pattern = $attributeInstance->pattern;
            }
        }
    }
}
