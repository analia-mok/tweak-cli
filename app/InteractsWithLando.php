<?php

namespace App;

use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

trait InteractsWithLando
{
    use ConstructsPaths;

    /**
     * A project's lando file path.
     *
     * @var string
     */
    protected $landoFilePath;

    /**
     * Lando file contents.
     *
     * @var array
     */
    protected $landoFile;

    /**
     * Retrieves lando file contents.
     *
     * @return array
     */
    public function getLandoFile(): array
    {
        if (!$this->landoFilePath) {
            $this->landoFilePath = $this->getPath([$this->setBasePath(), '.lando.yml']);
        }

        if (!File::isFile($this->landoFilePath)) {
            return [];
        }

        if (!$this->landoFile) {
            $this->landoFile = Yaml::parseFile($this->landoFilePath);
        }

        return $this->landoFile;
    }

    /**
     * Updates contents of lando file.
     *
     * @param array $contents
     * @return void
     */
    public function writeToLandoFile(array $contents)
    {
        if (!$this->landoFilePath) {
            $this->landoFilePath = $this->getPath([$this->setBasePath(), '.lando.yml']);
        }

        $yamlContent = Yaml::dump($contents, 5, 2);

        // Cleanup default format for single-line associate arrays.
        $yamlContent = preg_replace('/-\s+appserver/', '- appserver', $yamlContent);
        $yamlContent = preg_replace('/-\s+database/', '- database', $yamlContent);

        File::put($this->landoFilePath, $yamlContent);
    }
}
