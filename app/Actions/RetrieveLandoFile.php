<?php

namespace App\Actions;

use App\InteractsWithLando;
use App\LogsToConsole;

class RetrieveLandoFile
{
    use LogsToConsole, InteractsWithLando;

    public function __invoke()
    {
        return $this->getLandoFile();
    }
}
