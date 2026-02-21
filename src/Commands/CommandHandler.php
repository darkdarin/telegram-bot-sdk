<?php

namespace DarkDarin\TelegramBotSdk\Commands;

use DarkDarin\TelegramBotSdk\DTO\Message;
use DarkDarin\TelegramBotSdk\DTO\MessageEntityTypeEnum;
use DarkDarin\TelegramBotSdk\Exceptions\TelegramException;
use DarkDarin\TelegramBotSdk\Telegram;
use DarkDarin\TelegramBotSdk\TelegramClient;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class CommandHandler implements CommandHandlerInterface
{
    private array $commands = [];

    public function __construct(
        private readonly ContainerInterface $container,
    ) {}

    public function registerCommand(string $botName, object $command): void
    {
        if (!method_exists($command, 'handle')) {
            throw new \InvalidArgumentException('Command must have method [handle]');
        }

        $commandWrapper = new CommandWrapper($command);
        $this->commands[$botName][$commandWrapper->getName()][] = $commandWrapper;
        foreach ($commandWrapper->getAliases() as $alias) {
            $this->commands[$botName][$alias][] = $commandWrapper;
        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \ReflectionException
     */
    public function handle(string $botName, Message $message): void
    {
        $command = $this->findCommand($message);

        if ($command === null || empty($this->commands[$botName][$command->command])) {
            return;
        }
        foreach ($this->commands[$botName][$command->command] as $commandHandler) {
            $arguments = $this->parseArguments($commandHandler, $command);
            $this->handleCommand($botName, $message, $commandHandler, $arguments);
        }
    }

    private function findCommand(Message $message): ?MessageCommand
    {
        if ($message->entities === null) {
            return null;
        }

        foreach ($message->entities as $entity) {
            if ($entity->type === MessageEntityTypeEnum::BotCommand) {
                $command = substr($message->text, $entity->offset + 1, $entity->length - 1);
                $arguments = substr($message->text, $entity->offset + $entity->length + 1);
                return new MessageCommand($command, $arguments);
            }
        }

        return null;
    }

    public function parseArguments(CommandWrapper $commandWrapper, MessageCommand $messageCommand): array
    {
        $pattern = $commandWrapper->getPattern();
        [$regex, $parameters] = $this->makeRegexPattern($pattern);
        preg_match("%{$regex}%ixmu", $messageCommand->arguments, $matches, PREG_UNMATCHED_AS_NULL);

        $result = [];
        foreach ($matches as $key => $value) {
            if (in_array($key, $parameters)) {
                $result[$key] = $value;
            }
        }

        return array_filter($result);
    }

    private function makeRegexPattern(string $pattern): array
    {
        preg_match_all(
            pattern: '#\{\s*(?<name>\w+)\s*(?::\s*(?<pattern>\S+)\s*)?}#ixmu',
            subject: $pattern,
            matches: $matches,
            flags: PREG_SET_ORDER,
        );

        $patterns = collect($matches)
            ->mapWithKeys(function ($match): array {
                $pattern = $match['pattern'] ?? '[^ ]++';

                return [
                    $match['name'] => "(?<{$match['name']}>{$pattern})?",
                ];
            })
            ->filter();

        return [
            $patterns->implode('\s*'),
            $patterns->keys()->all(),
        ];
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \ReflectionException
     */
    private function handleCommand(string $botName, Message $message, CommandWrapper $commandWrapper, array $arguments): void
    {
        $command = $commandWrapper->getCommand();
        $parameters = $this->getMethodParameters($botName, $message, $command, $arguments);

        $command->handle(...$parameters);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \ReflectionException
     */
    private function getMethodParameters(string $botName, Message $message, object $command, array $arguments): array
    {
        $telegram = $this->container->get(Telegram::class);

        $parameters = [];
        $methodReflection = new \ReflectionMethod($command, 'handle');
        foreach ($methodReflection->getParameters() as $parameter) {
            if (array_key_exists($parameter->getName(), $arguments)) {
                $parameters[$parameter->getName()] = $arguments[$parameter->getName()];
                continue;
            }

            if ($parameter->getType() instanceof \ReflectionNamedType) {
                $typeName = $parameter->getType()->getName();
                if ($typeName === TelegramClient::class) {
                    $parameters[$parameter->getName()] = $telegram->bot($botName);
                    continue;
                } elseif ($typeName === Message::class) {
                    $parameters[$parameter->getName()] = $message;
                    continue;
                } elseif ($this->container->has($typeName)) {
                    $parameters[$parameter->getName()] = $this->container->get($typeName);
                    continue;
                }
            }

            if (!$parameter->isDefaultValueAvailable()) {
                throw new TelegramException(
                    sprintf(
                        'Command [%s] expects parameter [%s], but it not declared',
                        get_class($command),
                        $parameter->getName(),
                    ),
                );
            }
        }

        return $parameters;
    }
}
