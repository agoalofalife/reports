<?php
declare(strict_types=1);

namespace agoalofalife\Tests\Unit\Console;

use agoalofalife\Reports\Models\Report as ReportModel;
use agoalofalife\Tests\Support\FakeReport\TestReport;
use agoalofalife\Tests\TestCase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Support\Facades\Artisan;
use Maatwebsite\Excel\ExcelServiceProvider;

class ParseReportsCommandTest extends TestCase
{
    use InteractsWithDatabase;

    public function testHandleIsEmpty() : void
    {
        factory(ReportModel::class)->create([
            'class_name' => TestReport::class,
            'status' => ReportModel::STATUS_NEW
        ]);
        Artisan::call('reports:parse');
        $this->assertRegExp('/Reports in the status "in process" is missing/', Artisan::output());
    }

    public function testHandle() : void
    {
        factory(ReportModel::class)->create([
            'class_name' => TestReport::class,
            'status' => ReportModel::STATUS_PROCESS
        ]);
        $this->app->register(ExcelServiceProvider::class);
        Artisan::call('reports:parse');
        $this->assertDatabaseHas('reports', [
            'class_name' => TestReport::class,
            'status' => ReportModel::STATUS_WORKER
        ]);
    }
}