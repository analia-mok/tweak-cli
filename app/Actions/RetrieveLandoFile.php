<?php

namespace App\Actions;

use App\ConstructsPaths;
use App\LogsToConsole;
use Illuminate\Support\Facades\File;

class RetrieveLandoFile
{
    use LogsToConsole, ConstructsPaths;

    public function __construct()
    {
        $this->setBasePath();
    }

    public function __invoke()
    {
        $landoFilePath = $this->getPath([$this->basePath, '.lando.yml']);
        if (!File::isFile($landoFilePath)) {
            return '';
        }

        return $landoFilePath;
    }
}
