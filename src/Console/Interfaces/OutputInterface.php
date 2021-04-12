<?php

namespace Lenvendo\ConsoleCommands\Console\Interfaces;

/**
 * Интерфейс для всех классов вывода
 *
 * @package Lenvendo\ConsoleCommands\Console\Interfaces
 */
interface OutputInterface
{
    /**
     * Вывод сообщения
     *
     * @param string|iterable $messages
     * @param bool $newline
     */
    public function write($messages, bool $newline = false);

    /**
     * Вывод сообщения с переводом строки в конце
     *
     * @param string|iterable $messages The message as an iterable of strings or a single string
     */
    public function writeln($messages);
}
