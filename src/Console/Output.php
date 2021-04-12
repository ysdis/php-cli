<?php

namespace Lenvendo\ConsoleCommands\Console;

use Lenvendo\ConsoleCommands\Console\Interfaces\OutputInterface;

class Output implements OutputInterface
{
    /**
     * {@inheritdoc}
     */
    public function writeln($messages)
    {
        $this->write($messages, true);
    }

    /**
     * {@inheritdoc}
     */
    public function write($messages, bool $newline = false)
    {
        if (!is_iterable($messages)) {
            $messages = [$messages];
        }

        ob_start();

        foreach ($messages as $message) {
            if ($newline) {
                $message .= PHP_EOL;
            }

            print($message);
        }

        ob_flush();
    }
}
