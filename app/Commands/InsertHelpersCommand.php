<?php

namespace App\Commands;

use App\Actions\DetermineProjectType;
use App\Actions\InsertBaseHelpers;
use App\Actions\RetrieveLandoFile;
use App\Actions\VerifyDependencies;
use Exception;
use LaravelZero\Framework\Commands\Command;

class InsertHelpersCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'in';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Inserts lando helpers based on your current project structure.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app()->bind('console', function () {
            return $this;
        });

        try {
            app(VerifyDependencies::class)(['lando']);

            $projectType = app(DetermineProjectType::class)();
            $landoFile = app(RetrieveLandoFile::class)();

            if (empty($landoFile)) {
                // TODO: Need to figure out how to handle lando's interactive mode from
                // a Symfony process.
                // $answer = $this->confirm('No lando file exists. Would you like to create one?');

                // if (!$answer) {
                //     throw new Exception('Cannot continue without a lando file');
                // }

                // // Otherwise. Kickoff default lando file creation process.
                // $landoFile = app(CreateLandoFile::class)();
                throw new Exception('Lando file must exist before continuing. Run lando init first.');
            }

            $this->info('Lando File Discovered');

            // TODO: Remove me.
            $this->info(var_dump($landoFile));

            // Insert Base Helpers.
            app(InsertBaseHelpers::class)($projectType, $landoFile);

            // TODO: Insert Drupal-helpers.

            // TODO: Insert WordPress Helpers.

            // Done!
            $this->info("\nSUCCESS! Your project has been tweaked!");
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
