<?php

namespace App\Actions;

use Exception;
use TitasGailius\Terminal\Terminal;

class CreateLandoFile
{
    public function __invoke()
    {
        $response = Terminal::run('lando init .');

        if (!$response->ok()) {
            throw new Exception('FAILURE: Could not create lando file');
        }

        $landoFile = app(RetrieveLandoFile::class)();

        if (empty($landoFile)) {
            throw new Exception('FAILURE: Could not create lando file');
        }

        return $landoFile;
    }
}
