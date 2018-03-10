<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Console;
use Illuminate\Console\Command;


class SeederCommand extends Command
{
    protected $seeds = [
//        ModePostEmailSeeder::class,
//        StatusesSeeder::class
    ];
    protected $seedersPath = __DIR__.'/../../database/seeds/';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:seed';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill tables';
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() : void
    {
        $this->info('Seeding data into the database');
        foreach ($this->seeds as $seed) {
            if (!class_exists($seed)) {
                require_once $this->seedersPath . $seed .'.php';
            }
            (new $seed())->run();
        }
    }
}