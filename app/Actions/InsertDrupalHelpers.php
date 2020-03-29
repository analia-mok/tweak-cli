<?php

namespace App\Actions;

use App\InteractsWithLando;
use App\LogsToConsole;
use App\Stub;

class InsertDrupalHelpers
{
    use LogsToConsole, InteractsWithLando;

    public function __invoke(array &$landoFile)
    {
        $this->info('Tweaking in Drupal Helpers...');

        $landoFile['tooling']['phpcs'] = Stub::getYaml('drupal-phpcs');
        $landoFile['tooling']['phpcbf'] = Stub::getYaml('drupal-phpcbf');
        $landoFile['tooling']['drupal-update'] = Stub::getYaml('drupal-update');
        $landoFile['tooling']['catchup'] = Stub::getYaml('catchup');

        $this->writeToLandoFile($landoFile);
        $this->info("SUCCESS! .lando.yml now has Drupal helpers\n");
    }
}
