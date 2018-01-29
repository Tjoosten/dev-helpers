<?php

namespace Misfits\Helpers\Development\Creators;

/**
 * Class SharedCreator
 *
 * @package Misfits\Helpers\Development\Creators
 */
class SharedCreator
{
    /**
     * Get the directory path for the stubs.
     *
     * @return string
     */
    protected function getStubPath(): string
    {
        $path = __DIR__ . '/../resources/stubs/';

        return $path;
    }

    /**
     * Populate the stub with the needed data.
     *
     * @param  array $stubData      The data that needs to be populated
     * @param  string $stubPath     The path to the stub file.
     * @return mixed
     */
    protected function populateStub(array $stubData, string $stubPath)
    {
        foreach ($stubData as $search => $replace) {                // Loop through the populate data.
            $stubPath = str_replace($search, $replace, $stubPath);  // Populate the stub
        }

        return $stubPath; // Return the filled in stub.
    }
}