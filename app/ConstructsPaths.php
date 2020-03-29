<?php

namespace App;

trait ConstructsPaths
{
    /**
     * Path to current directory.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Retrieve current path.
     *
     * @return string|false
     */
    public function setBasePath()
    {
        if (!isset($this->basePath)) {
            $this->basePath = getcwd();
        }

        return $this->basePath;
    }

    /**
     * Constructs a path using path parts and the correct directory separator.
     *
     * @param array $parts
     * @return string
     */
    public function getPath(array $parts): string
    {
        return array_reduce($parts, function ($carry, $item) {
            return $carry . DIRECTORY_SEPARATOR . $item;
        });
    }
}
