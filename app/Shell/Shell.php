<?php

namespace App\Shell;

use App\ConstructsPaths;
use Symfony\Component\Process\Process;

/**
 * Based on Tighten's Lambo for handling external command execution.
 *
 * @link https://github.com/tightenco/lambo/blob/master/app/Shell/Shell.php
 */
class Shell
{
    use ConstructsPaths;

    public function __construct()
    {
        $this->setBasePath();
    }

    public function getOutputFormatter()
    {
        return app('console')->option('no-ansi') ? new PlainOutputFormatter : new ColorOutputFormatter;
    }

    public function buildProcess($command): Process
    {
        $process = app()->make(Process::class, [
            'command' => $command,
        ]);
        $process->setTimeout(null);
        return $process;
    }

    /**
     * Executes a given command inside the current project.
     *
     * @param string $command
     * @return \Symfony\Component\Process\Process
     */
    public function execute(string $command)
    {
        return $this->exec($command, $command);
    }

    protected function exec($command, $description)
    {
        $out = app(\Symfony\Component\Console\Output\ConsoleOutput::class);

        $outputFormatter = $this->getOutputFormatter();
        $out->writeln($outputFormatter->start($description));

        $process = $this->buildProcess(["cd {$this->basePath}", $command]);
        $process->run(function ($type, $buffer) use ($out, $outputFormatter) {
            if (empty($buffer) || $buffer === PHP_EOL) {
                return;
            }

            if (Process::ERR === $type) {
                $out->writeln(
                    $outputFormatter->progress(
                        $buffer,
                        Process::ERR === $type
                    )
                );
            }
        });

        return $process;
    }
}
