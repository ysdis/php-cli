<?php

namespace Lenvendo\ConsoleCommands\Console\Interfaces;

/**
 * Интерфейс для всех классов консоли
 *
 * @package Lenvendo\ConsoleCommands\Console\Interfaces
 */
interface ConsoleInterface
{
    /**
     * Обработка ввода и запуск команды
     * Централизованно отвечает за обработку исключений, возникших во время
     * попытки исполнения/исполнения команды и непосредственный запуск тела
     * консольной команды
     *
     * @return int
     */
    function handle(): int;

    /**
     * Регистрация всех команд в заданных директориях
     *
     * @param  array|string $paths Директории в которых будет совершён поиск
     * @return void
     */
    function load($paths);

    /**
     * Вывод информации о всех зарегистрированных командах в консоли
     *
     */
    function getListOfAllCommands();

    /**
     * Завершение работы консоли
     *
     * @param int $status
     * @return void
     */
    function terminate(int $status = 0);
}