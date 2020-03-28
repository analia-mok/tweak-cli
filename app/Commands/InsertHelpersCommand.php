<?php

namespace App\Commands;

use App\Actions\InsertHelpers;
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

            // TODO: Separate project type and lando discovery.
            // Want to be able to prompt user if they want to create a lando file.

            app(InsertHelpers::class)();
        } catch (Exception $e) {
            $this->error("\nFAILURE: " . $e->getMessage());
        }
    }
}
