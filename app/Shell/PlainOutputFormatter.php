<?php

namespace App\Shell;

/**
 * Taken from Tighten's Lambo for non-ANSI terminals.
 *
 * @link https://github.com/tightenco/lambo/blob/master/app/Shell/PlainOutputFormatter.php
 */
class PlainOutputFormatter extends ConsoleOutputFormatter
{
    public function getStartMessageFormat(): string
    {
        return "[ RUN ] %s";
    }

    public function getErrorMessageFormat(): string
    {
        return "[ ERR ] %s";
    }

    public function getMessageFormat(): string
    {
        return "[ OUT ] %s";
    }
}
