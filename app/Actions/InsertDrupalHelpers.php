<?php

namespace App\Actions;

use App\InteractsWithLando;
use App\Stub;

class InsertDrupalHelpers
{
    use InteractsWithLando;

    public function __invoke(array &$landoFile)
    {
        $landoFile['tooling']['phpcs'] = Stub::getYaml('drupal-phpcs');
        $landoFile['tooling']['phpcbf'] = Stub::getYaml('drupal-phpcbf');
        $landoFile['tooling']['drupal-update'] = Stub::getYaml('drupal-update');
        $landoFile['tooling']['catchup'] = Stub::getYaml('catchup');

        $this->writeToLandoFile($landoFile);
    }
}
