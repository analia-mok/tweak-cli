<?php

namespace App\Commands;

use App\Actions\InsertHelpers;
use App\Actions\RetrieveLandoFile;
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
            // app(VerifyDependencies::class)(['lando']);

            // TODO: Separate project type and lando discovery.
            // Want to be able to prompt user if they want to create a lando file.
            // $projectType = app(DetermineProjectType::class)();
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

            app(InsertHelpers::class)();
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
