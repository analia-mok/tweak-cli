<?php

namespace App\Actions;

use App\ConstructsPaths;
use App\LogsToConsole;

class InsertHelpers
{
    use LogsToConsole, ConstructsPaths;

    public function __construct()
    {
        $this->setBasePath();
    }

    public function __invoke()
    {
        $this->info('Tweaking in helpers...');

        // TODO

        $this->info('SUCCESS! Your project has been tweaked!');
    }
}
