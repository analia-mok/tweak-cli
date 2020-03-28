<?php

namespace App\Actions;

use App\LogsToConsole;

class InsertHelpers
{
    use LogsToConsole;

    public function __invoke()
    {
        // TODO: Insert.
        $this->info('Tweaking in helpers...');

        // TODO: Determine project type (if possible).
        // TODO: Get lando file if it exists.
        // TODO: If lando DNE, error and tell user.
    }
}
