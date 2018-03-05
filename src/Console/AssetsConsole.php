<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Console;
use Illuminate\Console\Command;

class AssetsConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:assets';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-publish the reports assets';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() : void
    {
        $this->call('vendor:publish', [
            '--tag' => 'reports-assets',
            '--force' => true,
        ]);
    }
}