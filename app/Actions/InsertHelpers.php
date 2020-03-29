<?php

namespace App\Actions;

use App\ConstructsPaths;
use App\LogsToConsole;

class InsertHelpers
{
    use LogsToConsole, ConstructsPaths;

    /**
     * Path to lando file.
     *
     * @var string
     */
    protected $landoPath;

    public function __construct()
    {
        $this->setBasePath();

        $this->landoPath = $this->getPath([$this->basePath, '.lando.yml']);
    }

    /**
     * Inserts stubs into current project and adjusts lando file.
     *
     * @param string $projectType - Type of project
     * @param array $landoFile - Contents of current lando file
     * @return void
     */
    public function __invoke(string $projectType, array $landoFile)
    {
        $this->info("Tweaking in helpers...\n");

        // TODO: Consider a Drupal insert and a WordPress insert.
        // TODO: Both recipes only share pulldb and pullfiles with minor variations.

        // TODO: Copy and paste stubs.
        // TODO: Make YAML constructor?

        $this->info("\nSUCCESS! Your project has been tweaked!");
    }
}
