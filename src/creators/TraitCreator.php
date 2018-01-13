<?php

namespace Misfits\Helpers\Development\Creators;

use Illuminate\Filesystem\Filesystem;

/**
 * Class TraitCreator
 *
 * @package Misfits\Helpers\Development\Creators
 */
class TraitCreator extends SharedCreator
{
    /**
     * @var Filesystem $filesystem
     */
    protected $filesystem;

    /**
     * @var string $trait
     */
    protected $trait;

    /**
     * TraitCreator constructor
     *
     * @param  Filesystem $filesystem
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Get the trait name.
     *
     * @return string
     */
    public function getTrait(): string
    {
        return $this->trait;
    }

    /**
     * Set the traitName in some variable.
     *
     * @param $traitName
     */
    public function setTrait($traitName): void
    {
        $this->trait = $traitName;
    }

    /**
     * Create the trait
     *
     * @param  string $trait The name for the trait instance.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @return int
     */
    public function create(string $trait): int
    {
        $this->setTrait($trait);     // Set the trait
        $this->createDirectory();    // Create the folder directory

        return $this->createTrait(); // Return result
    }

    /**
     * Create the directory if it doesn't exists.
     *
     * @return void
     */
    public function createDirectory(): void
    {
        $directory = $this->getDirectory();

        if (! $this->filesystem->isDirectory($directory)) { // Check if the directory exists.
            // Create the directory, if it doesn't exists.
            $this->filesystem->makeDirectory($directory, 0755, true);
        }
    }

    /**
     * Get the directory from the config.
     *
     * @return string
     */
    public function getDirectory(): string
    {
        return config('dev-helpers.paths.trait');
    }

    /**
     * Create the trait in the system.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @return int
     */
    protected function createTrait(): int
    {
        $result = $this->filesystem->put($this->getPath(), $this->populateStub());

        return $result;
    }

    /**
     * Get the path from the trait.
     *
     * @return string
     */
    protected function getPath(): string
    {
        return $this->getDirectory() . DIRECTORY_SEPARATOR . $this->getTrait() . '.php';
    }

    /**
     * Populate the stub with the needed data.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @return mixed
     */
    protected function populateStub()
    {
        $stubData = $this->getPopulateData();   // Get the data for the population
        $stubPath = $this->getStub();           // Get the path to the trait stub

        foreach ($stubData as $search => $replace) {                // Loop through the populate data.
            $stubPath = str_replace($search, $replace, $stubPath);  // Populate the stub
        }

        return $stubPath; // Return the filled in stub.
    }

    /**
     * Get the full path for the trait stub.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @return string
     */
    protected function getStub(): string
    {
        return $this->filesystem->get($this->getStubPath() . 'trait.stub');
    }

    /**
     * Get the data for the attrib. population.
     *
     * @return array
     */
    protected function getPopulateData(): array
    {
        return [
            'trait_class'     => ucfirst($this->getTrait()),
            'trait_namespace' => config('dev-helpers.namespaces.trait'),
        ];
    }
}