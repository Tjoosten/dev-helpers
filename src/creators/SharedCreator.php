<?php

namespace Misfits\Helpers\Development\Creators;

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
}