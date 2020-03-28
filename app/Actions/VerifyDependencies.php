<?php

namespace App\Actions;

use App\LogsToConsole;
use Exception;
use Symfony\Component\Process\ExecutableFinder;

class VerifyDependencies
{
    use LogsToConsole;

    /**
     * Finder for OS executables.
     *
     * @var Symfony\Component\Process\ExecutableFinder
     */
    protected $finder;

    public function __construct(ExecutableFinder $finder)
    {
        $this->finder = $finder;
    }

    public function __invoke(array $dependencies)
    {
        $this->info("Verifying dependencies...");

        foreach ($dependencies as $dep) {
            if ($this->finder->find($dep) === null) {
                throw new Exception($dep . ' is not installed');
            }
        }

        $this->info('All Dependencies are available: ' . implode(', ', $dependencies) . "\n");
    }
}
