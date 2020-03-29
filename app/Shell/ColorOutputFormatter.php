<?php

namespace App\Shell;

/**
 * Taken from Tighten's Lambo for handling ansi supported terminals.
 *
 * @link https://github.com/tightenco/lambo/blob/master/app/Shell/ColorOutputFormatter.php
 */
class ColorOutputFormatter extends ConsoleOutputFormatter
{
    public function getStartMessageFormat(): string
    {
        return "<bg=blue;fg=white> RUN </> <fg=blue>%s</>";
    }

    public function getErrorMessageFormat(): string
    {
        return "<bg=red;fg=white> ERR </> %s";
    }

    public function getMessageFormat(): string
    {
        return "<bg=green;fg=white> OUT </> %s";
    }
}
