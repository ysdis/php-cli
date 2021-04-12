<?php

namespace Lenvendo\ConsoleCommands\Console;

use Lenvendo\ConsoleCommands\Console\Interfaces\InputInterface;
use Lenvendo\ConsoleCommands\Console\Interfaces\OutputInterface;

/**
 * Класс консольной команды
 *
 * @package Lenvendo\ConsoleCommands\Console
 */
class Command
{
    protected array $help           = [];
    protected string $name          = '';
    protected string $description   = '';

    protected InputInterface    $input;
    protected OutputInterface   $output;

    public function __construct(InputInterface $input, OutputInterface $output = null)
    {
        $this->input = $input;

        if (!empty($output)) {
            $this->output = $output;
        }
    }

    protected function run() {}

    /**
     * Запуск пользовательской логики команды, если был передан аргумент {help}
     * то произойдёт вывод описания команды
     *
     * @return int|void
     */
    public function execute()
    {
        if ($this->hasArgument('help')) {
            $this->writeln([
                'Command help:',
            ]);
            $this->writeln($this->help);
        } else {
            return $this->run() ?? 0;
        }
    }

    public function hasArgument($name): bool
    {
        return $this->input->hasArgument($name);
    }

    public function arguments(): array
    {
        return $this->input->getArguments();
    }

    public function hasOption(string $name): bool
    {
        return $this->input->hasOption($name);
    }

    public function option($key = null)
    {
        if (is_null($key)) {
            return $this->input->getOptions();
        }

        return $this->input->getOption($key);
    }

    public function options()
    {
        return $this->option();
    }

    //--------------------------- Shortcuts ---------------------------//

    public function writeln($messages)
    {
        $this->output->writeln($messages);
    }

    public function write($message, $newline = false)
    {
        $this->output->write($message, $newline);
    }

    //---------------------------- Getters ----------------------------//

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getHelp(): array
    {
        return $this->help;
    }
}
