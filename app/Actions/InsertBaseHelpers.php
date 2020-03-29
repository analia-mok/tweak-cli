<?php

namespace App\Actions;

use App\InteractsWithLando;
use App\LogsToConsole;
use App\ProjectTypeEnum;
use App\Stub;
use Illuminate\Support\Facades\File;

class InsertBaseHelpers
{
    use LogsToConsole, InteractsWithLando;

    /**
     * Path to lando file.
     *
     * @var string
     */
    protected $landoPath;

    public function __construct()
    {
        $this->landoPath = $this->getPath([$this->setBasePath(), '.lando.yml']);
    }

    /**
     * Inserts stubs into current project and adjusts lando file.
     *
     * @param string $projectType - Type of project
     * @param array $landoFile - Contents of current lando file
     * @return array Send back adjusted lando file.
     */
    public function __invoke(string $projectType, array &$landoFile)
    {
        $this->info("Tweaking in base helpers...\n");

        $this->createScripts($projectType);

        // Add Lando configuration.
        $this->adjustLandoFile($projectType, $landoFile);
    }

    /**
     * Generates scripts directory and script files
     *
     * @param string $projectType
     * @return void
     */
    public function createScripts(string $projectType)
    {
        // Create script files.
        $installMessage = '';
        $uploadsPath = '';
        $firstTimeSetupStubPath = '';

        // Setup script differences.
        if ($projectType === ProjectTypeEnum::DRUPAL_COMPOSER || $projectType === ProjectTypeEnum::DRUPAL) {
            $installMessage = 'Installing packages and Drupal Core. This might take a while...';

            if ($projectType === ProjectTypeEnum::DRUPAL_COMPOSER) {
                $uploadsPath = '/app/web/sites/default/files';
            } else {
                $uploadsPath = '/app/sites/default/files';
            }

            $firstTimeSetupStubPath = 'drupal-first-time-setup';
        } elseif ($projectType === ProjectTypeEnum::WORDPRESS_COMPOSER) {
            $installMessage = 'Installing packages...';
            $uploadsPath = '/app/web/wp-content/uploads';
            $firstTimeSetupStubPath = 'wordpress-first-time-setup';
        } elseif ($projectType === ProjectTypeEnum::WORDPRESS) {
            $installMessage = 'Setting up project...';
            $uploadsPath = '/app/wp-content/uploads';
            $firstTimeSetupStubPath = 'wordpress-first-time-setup';
        } else {
            $installMessage = 'Setting up project...';
        }

        // Get File Contents.
        $getPantheonFileBackupStub = Stub::getShell('get-pantheon-files-backup');
        $getPantheonDbBackupStub = Stub::getShell('get-pantheon-db-backup');
        $firstTimeSetupStub = Stub::getShell($firstTimeSetupStubPath);

        // Replace placeholders.
        $getPantheonFileBackupStub = str_replace('{{ FILES_PATH }}', $uploadsPath, $getPantheonFileBackupStub);
        $firstTimeSetupStub = str_replace('{{ INSTALL_MSG }}', $installMessage, $firstTimeSetupStub);

        // Create Actual Files.
        $scriptDirPath = $this->getPath([$this->basePath, 'scripts/lando-helpers']);
        if (!File::isDirectory($scriptDirPath)) {
            // Make scripts dir first, then the lando-helpers dir.
            File::makeDirectory($this->getPath([$this->basePath, 'scripts']));
            File::makeDirectory($scriptDirPath);
        }

        File::put($this->getPath([$scriptDirPath, 'first-time-setup.sh']), $firstTimeSetupStub);
        File::put($this->getPath([$scriptDirPath, 'get-pantheon-db-backup.sh']), $getPantheonDbBackupStub);
        File::put($this->getPath([$scriptDirPath, 'get-pantheon-files-backup.sh']), $getPantheonFileBackupStub);

        $this->info('Success! Created scripts');
    }

    /**
     * Adds scripts to lando's tooling section.
     *
     * @param string $projectType
     * @param array $landoFile
     * @return void
     */
    public function adjustLandoFile(string $projectType, array &$landoFile)
    {
        if ($projectType === ProjectTypeEnum::DRUPAL || $projectType === ProjectTypeEnum::DRUPAL_COMPOSER) {
            $firstTimeSetupConfig = Stub::getYaml('drupal-setup');
        } else {
            $firstTimeSetupConfig = Stub::getYaml('wordpress-setup');
        }

        $pulldbConfig = Stub::getYaml('pulldb');
        $pullfilesConfig = Stub::getYaml('pullfiles');

        $landoFile['tooling']['setup'] = $firstTimeSetupConfig;
        $landoFile['tooling']['pulldb'] = $pulldbConfig;
        $landoFile['tooling']['pullfiles'] = $pullfilesConfig;

        $this->writeToLandoFile($landoFile);

        $this->info('Success! .lando.yml adjusted');
    }
}
