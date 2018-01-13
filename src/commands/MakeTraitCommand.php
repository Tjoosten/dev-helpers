<?php

namespace Misfits\Helpers\Development\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Misfits\Helpers\Development\Creators\TraitCreator;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MakeTraitCommand
 *
 * @package Misfits\Helpers\Development\Commands
 */
class MakeTraitCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'make:trait';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new trait for the application';

    /**
     * @var TraitCreator
     */
    protected $creator;

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * MakeTraitCommand constructor.
     *
     * @param  TraitCreator $creator
     * @return void
     */
    public function __construct(TraitCreator $creator)
    {
        parent::__construct();

        $this->creator = $creator;              // Set the creator
        $this->composer = app()['composer'];    // Set the composer
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $arguments = $this->argument();   // Get the arguments

        $this->writeTrait($arguments);    // Write criteria
        $this->composer->dumpAutoloads(); // Dump autoload
    }

    /**
     * Write the trait in the application files.
     *
     * @param  array $arguments The command arguments
     * @return void
     */
    public function writeTrait(array $arguments): void
    {
        if ($this->creator->create($arguments['name'])) { // Create the trait
            $this->info('Successfully created the trait class.'); // Information message
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    public function getArguments(): array
    {
        return [['name', InputArgument::REQUIRED, 'The trait name.']];
    }
}