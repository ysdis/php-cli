<?php

namespace Lenvendo\ConsoleCommands\Console;

use Lenvendo\ConsoleCommands\Console\Interfaces\ConsoleInterface as KernelConsole;
use Lenvendo\ConsoleCommands\Console\Interfaces\InputInterface;
use Lenvendo\ConsoleCommands\Console\Interfaces\OutputInterface;
use Throwable;

class Console implements KernelConsole
{
    /**
     * Все команды, зарегистрированные в консоли
     *
     * @var Command[]
     */
    protected array $commands = [];

    /**
     * Список директорий для поиска в них команд
     *
     * @var array|string[]
     */
    public array $paths = [];

    const PACKAGE_NAMESPACE = 'Lenvendo\ConsoleCommands';

    public InputInterface $input;
    public OutputInterface $output;

    public function __construct($input, $output = null, array $additionalPaths = [])
    {
        if (empty($output)) {
            $this->output = new Output();
        }
        $this->input = $input;

        $this->paths[] = realpath(dirname(__DIR__) . '/Commands');
        $this->paths = array_merge($this->paths, $additionalPaths);

        $this->load($this->paths);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(): int
    {
        $currentCommand = $this->input->getCommandName();

        try {
            foreach ($this->commands as $command) {
                if ($command->getName() === $currentCommand) {
                    return $command->execute();
                }
            }

            $this->getListOfAllCommands();

        } catch (Throwable $e) {
            return 1;
        }

        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function load($paths)
    {
        $paths = array_unique($paths ?? is_array($paths) ? $paths : [$paths]);

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return;
        }

        foreach ($paths as $path) {
            foreach (glob("$path/*.php") as $file) {
                $command = self::PACKAGE_NAMESPACE.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    array_reverse(explode(dirname($path), $file, 2))[0]
                );

                if (is_subclass_of($command, Command::class)) {
                    $this->commands[] = new $command($this->input, $this->output);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getListOfAllCommands()
    {
        $this->writeln([
            'Usage:',
            '    command [arguments] [options]',
            '',
            'Arguments:',
            '    {help} Display help for the given command.',
            'Available commands:',
        ]);

        $maxCommandNameLength = 0;

        foreach ($this->commands as $command) {
            if ($maxCommandNameLength < $length = strlen($command->getName())) {
                $maxCommandNameLength = $length;
            }
        }

        foreach ($this->commands as $command) {
            $indent = str_repeat(' ', $maxCommandNameLength - strlen($command->getName()) + 2);
            $this->writeln('    ' . $command->getName() . $indent . $command->getDescription());
        }
    }

    public function terminate(int $status = 0)
    {
        die($status);
    }

    public function writeln($messages)
    {
        $this->output->writeln($messages);
    }

    public function write($message, $newline = false)
    {
        $this->output->write($message, $newline);
    }
}
