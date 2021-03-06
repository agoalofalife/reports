<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Console;

use agoalofalife\Reports\Models\Report;
use Illuminate\Console\Command;

/**
 * Class ParseReportsCommand
 * @package agoalofalife\Reports\Console
 */
class ParseReportsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search reports which status is "process"';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() : void
    {
        $reportInProcess = Report::where('status', Report::STATUS_PROCESS)->get();

        if ($reportInProcess->count() > 0) {
            $reportInProcess = $reportInProcess->random();
            $reportInProcess->update([
                'pid' => getmypid(),
                'status' => Report::STATUS_WORKER
            ]);
            $this->call('reports:handle', ['classReport' => $reportInProcess->class_name]);
        } else {
            $this->warn('Reports in the status "in process" is missing');
        }
    }
}