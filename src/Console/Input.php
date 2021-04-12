<?php

namespace Lenvendo\ConsoleCommands\Console;

use InvalidArgumentException;
use Lenvendo\ConsoleCommands\Console\Interfaces\InputInterface;

class Input implements InputInterface
{
    /**
     * Список обработанных параметров
     *
     * @var array
     */
    protected array $options = [];

    /**
     * Список обработанных аргументов
     *
     * @var array
     */
    protected array $arguments = [];

    /**
     * Наименование вызываемой команды
     *
     * @var string
     */
    protected string $commandName = 'default-name';

    private array $tokens;

    public function __construct(array $argv = null)
    {
        $argv = $argv ?? $_SERVER['argv'] ?? [];

        array_shift($argv);

        $this->tokens = $argv;

        $this->commandName = $this->tokens[0] ?? $this->commandName;

        $this->parse();
    }

    protected function parse()
    {
        array_shift($this->tokens);

        $parsed = $this->tokens;

        while (null !== $token = array_shift($parsed)) {
            if (mb_substr($token, 0, 1) === '{' && mb_substr($token, -1, 1) === '}' ||
                mb_substr($token, 0, 1) !== '[' && mb_substr($token, -1, 1) !== ']') {
                $this->parseArgument($token);
            } elseif (mb_substr($token, 0, 1) === '[' && mb_substr($token, -1, 1) === ']' && substr_count($token, '=') === 1) {
                $this->parseOption($token);
            }
        }

        $this->arguments = array_unique($this->arguments);
    }

    /**
     * {@inheritoc}
     */
    public function parseArgument(string $token)
    {
        if (mb_substr($token, 0, 1) === '{' && mb_substr($token, -1, 1) === '}') {
            $argument = mb_substr($token, 1, -1);
        } else {
            $argument = $token;
        }

        $this->arguments[] = $argument;
    }

    /**
     * {@inheritoc}
     */
    public function parseOption(string $token)
    {
        [$key, $value] = explode('=', mb_substr($token, 1, -1));

        if (empty($value)) {
            return;
        }

        if (!empty($this->options[$key])) {
            if (is_array($this->options[$key])) {
                $this->options[$key][] = $value;
            } else {
                $this->options[$key] = [
                    $this->options[$key],
                    $value
                ];
            }
        } else {
            $this->options[$key] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasOption(string $name): bool
    {
        return isset($this->options[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getOption(string $name)
    {
        if (!$this->hasOption($name)) {
            throw new InvalidArgumentException(sprintf('The "%s" option does not exist.', $name));
        }

        return $this->options[$name];
    }


    /**
     * {@inheritdoc}
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function setOption(string $name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function hasArgument($name): bool
    {
        return in_array($name, $this->arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function setArgument(string $name)
    {
        $this->arguments[] = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommandName(): string
    {
        return $this->commandName;
    }
}
