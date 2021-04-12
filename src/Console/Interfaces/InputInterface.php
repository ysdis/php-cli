<?php

namespace Lenvendo\ConsoleCommands\Console\Interfaces;

use InvalidArgumentException;

/**
 * Интерфейс для всех классов ввода
 *
 * @package Lenvendo\ConsoleCommands\Console\Interfaces
 */
interface InputInterface
{
    /**
     * Парсинг переданных в консоль аргументов
     *
     * @param string $token
     * @return void
     */
    public function parseArgument(string $token);

    /**
     * Парсинг переданных в консоль параметров
     *
     * @param string $token
     * @return void
     */
    public function parseOption(string $token);

    /**
     * Возвращает вызываемое имя команды
     *
     * @return string
     */
    public function getCommandName(): string;

    /**
     * Возвращает все аргументы
     *
     * @return array
     */
    public function getArguments(): array;

    /**
     * Запись нового аргумента
     *
     * @param string $name
     */
    public function setArgument(string $name);

    /**
     * Возвращает true, если аргумент существует в InputInterface
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasArgument($name): bool;

    /**
     * Возвращает все параметры
     *
     * @return array
     */
    public function getOptions(): array;

    /**
     * Возвращает данные по имени параметра
     *
     * @return string|string[]|bool|null Содержимое параметра
     * @throws InvalidArgumentException When option given doesn't exist
     */
    public function getOption(string $name);

    /**
     * Устанавливает значение для параметра по имени
     *
     * @param string|string[]|bool|null $value The option value
     */
    public function setOption(string $name, $value);

    /**
     * Возвращает true, если параметр существует в InputInterface
     *
     * @param string $name
     * @return bool
     */
    public function hasOption(string $name): bool;
}
