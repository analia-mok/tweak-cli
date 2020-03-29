<?php

namespace App\Actions;

use App\Shell\Shell;
use Exception;

class CreateLandoFile
{
    /**
     * Instance of a command shell.
     *
     * @var App\Shell\Shell
     */
    protected $shell;

    public function __construct(Shell $shell)
    {
        $this->shell = $shell;
    }

    public function __invoke()
    {
        /** @var \Symfony\Component\Process\Process $process */
        $process = $this->shell->execute('lando init');

        if (!$process->isSuccessful()) {
            throw new Exception('FAILURE: Could not create lando file');
        }

        $landoFile = app(RetrieveLandoFile::class)();

        if (empty($landoFile)) {
            throw new Exception('FAILURE: Could not create lando file');
        }

        return $landoFile;
    }
}
