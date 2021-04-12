<?php

use Lenvendo\ConsoleCommands\Console\Command;

class BeautifyInputInfoCommand extends Command
{
    protected string $name = 'beautify-input';

    protected string $description = 'Вывод всех аргументов и опций в удобочитаемом для пользователя формате';

    protected array $help = [
        'beautify-input {arg1} {arg2, arg3} [param1=1] [param2={1,3,5}] {arg4}',
        '    Выводит все переданные команде в неограниченном количестве аргументы, опции',
        '    в формате удобном для чтении пользователю.'
    ];

    protected function run()
    {
        $this->writeln([
            'Called command: ' . $this->name,
            '',
            'Arguments',
        ]);

        foreach ($this->arguments() as $argument) {
            $this->writeln('    -  ' . $argument);
        }

        $this->writeln('Options:');

        foreach ($this->options() as $name => $value) {
            $this->writeln('    -  ' . $name);

            if (is_array($value)) {
                foreach ($value as $item) {
                    $this->writeln('        -  ' . $item);
                }
            } else {
                $this->writeln('        -  ' . $value);
            }
        }
    }
}

