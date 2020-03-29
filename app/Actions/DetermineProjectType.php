<?php

namespace App\Actions;

use App\ConstructsPaths;
use App\LogsToConsole;
use App\ProjectTypeEnum;
use Exception;
use Illuminate\Support\Facades\File;

class DetermineProjectType
{
    use LogsToConsole, ConstructsPaths;

    /**
     * All composer package names for drupal projects.
     *
     * @var array
     */
    const DRUPAL_PACKAGE_NAMES = [
        'drupal/core-recommended',
        'drupal/recommended-project', // 8.8+
        'drupal/core',
    ];

    /**
     * Directories that exist for all Drupal projects.
     *
     * @var array
     */
    const DRUPAL_DIRS = [
        'web' . DIRECTORY_SEPARATOR . 'core',
        'web' . DIRECTORY_SEPARATOR . 'themes',
        'core',
        'sites',
    ];

    /**
     * All composer package names for wordpress projects.
     * TODO: List needs to be expanded.
     *
     * @var array
     */
    const WORDPRESS_PACKAGE_NAMES = [
        'pantheon-systems/wordpress-composer',
    ];

    /**
     * Directories that exist for all WordPress projects.
     *
     * @var array
     */
    const WORDPRESS_DIRS = [
        'wp-content', // Vanilla
        'web' . DIRECTORY_SEPARATOR . 'wp-content', // Pantheon
        'web' . DIRECTORY_SEPARATOR . 'wp', // Bedrock
    ];

    public function __construct()
    {
        $this->setBasePath();
    }

    public function __invoke(): string
    {
        // Determine project type (if possible).
        $projectType = $this->getProjectType();

        if ($projectType === ProjectTypeEnum::UNKNOWN) {
            throw new Exception('Could not determine what kind of project you are tweaking');
        }

        $this->line("Project type discovered: {$projectType}");

        return $projectType;
    }

    /**
     * Determine type of project we are in based on project files and structure.
     *
     * @return string
     */
    protected function getProjectType(): string
    {
        $composerFilePath = $this->getPath([$this->basePath, 'composer.json']);

        if (File::isFile($composerFilePath)) {
            // Run through drupal and/or wp possibilities.
            $composerRawContents = File::get($composerFilePath);

            if (empty($composerRawContents)) {
                throw new Exception('composer.json file has nothing in it...');
            }

            $composerContents = json_decode($composerRawContents, true);

            if (isset($composerContents['require'])) {
                foreach ($composerContents['require'] as $requirement) {
                    // Is Drupal?
                    if (in_array($requirement, self::DRUPAL_PACKAGE_NAMES)) {
                        return ProjectTypeEnum::DRUPAL;
                    }

                    // Is WordPress?
                    if (in_array($requirement, self::WORDPRESS_PACKAGE_NAMES)) {
                        return ProjectTypeEnum::WORDPRESS;
                    }
                }
            }
        }

        /// Otherwise, run through directory possibilities.

        // Is Drupal?
        foreach (self::DRUPAL_DIRS as $dir) {
            if (File::isDirectory($this->getPath([$this->basePath, $dir]))) {
                return ProjectTypeEnum::DRUPAL;
            }
        }

        // Is WordPress?
        foreach (self::WORDPRESS_DIRS as $dir) {
            if (File::isDirectory($this->getPath([$this->basePath, $dir]))) {
                return ProjectTypeEnum::WORDPRESS;
            }
        }

        return ProjectTypeEnum::UNKNOWN;
    }
}
