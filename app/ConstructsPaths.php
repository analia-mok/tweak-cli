<?php

namespace App;

trait ConstructsPaths
{
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
