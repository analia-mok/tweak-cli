<?php

namespace App;

use Exception;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class Stub
{
    /**
     * Retrieves contents of a yaml stub.
     *
     * @param string $filename - name of file without extension.
     * @throws Exception
     * @return array
     */
    public static function getYaml(string $filename): array
    {
        try {
            return Yaml::parseFile(base_path("app/Stubs/Yaml/{$filename}.yml"));
        } catch (ParseException $e) {
            throw new Exception($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Retrieve shell script stub.
     *
     * @param string $filename - name of file without extension.
     * @return string
     */
    public static function getShell(string $filename): string
    {
        return File::get(base_path("app/Stubs/ShellScripts/{$filename}.stub"));
    }
}
