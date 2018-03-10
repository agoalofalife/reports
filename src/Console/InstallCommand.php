<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Console;

use Illuminate\Console\Command;

/**
 * Class InstallCommand
 * @package agoalofalife\Reports\Console
 */
class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the commands necessary to prepare for use';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() : void
    {
        $this->call('vendor:publish', ['--tag' => 'reports-migration']);
        $this->call('migrate');
        $this->call('reports:seed');
        $this->call('reports:assets');
    }
}