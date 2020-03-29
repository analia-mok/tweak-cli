<?php

namespace App\Shell;

/**
 * Taken from Tighten's Lambo for handling ANSI difference between terminals.
 *
 * @link https://github.com/tightenco/lambo/blob/master/app/Shell/ConsoleOutputFormatter.php
 */
abstract class ConsoleOutputFormatter
{
    public function start(string $message)
    {
        return sprintf($this->getStartMessageFormat(), $message);
    }

    public function progress(string $buffer, bool $error)
    {
        if ($error) {
            return rtrim(sprintf($this->getErrorMessageFormat(), $buffer));
        }

        return rtrim(sprintf($this->getMessageFormat(), $buffer));
    }

    abstract public function getStartMessageFormat(): string;

    abstract public function getErrorMessageFormat(): string;

    abstract public function getMessageFormat(): string;
}
