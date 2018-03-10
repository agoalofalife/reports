<?php
declare(strict_types=1);

namespace agoalofalife\Tests\Unit\Console;

use agoalofalife\Reports\Report;
use agoalofalife\Reports\Models\Report as ReportModel;
use agoalofalife\Tests\Support\FakeReport\TestReport;
use agoalofalife\Tests\TestCase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Support\Facades\Artisan;
use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;
use Mockery;

class HandleReportCommandTest extends TestCase
{
    use InteractsWithDatabase;

    public function testHandleClassIsNotExist() : void
    {
        $this->expectExceptionMessage('Test\S class not exist');
        Artisan::call('reports:handle', ['classReport' => 'Test\\S']);
    }

    public function testHandleClassIsNotSubclass() : void
    {
        $this->expectExceptionMessage(TestCase::class . ' class is not subclass ' . Report::class);
        Artisan::call('reports:handle', ['classReport' => TestCase::class]);
    }

    public function testHandle() : void
    {
        $report = app()->make(TestReport::class);
        factory(ReportModel::class)->create([
            'class_name' => TestReport::class
        ]);
        $excelWriter = $this->mock(LaravelExcelWriter::class);
        $this->app->register(ExcelServiceProvider::class);
        Excel::shouldReceive('create')
            ->once()->with($report->getFileName(), [$report, 'handler'])->andReturn($excelWriter);
        $excelWriter->shouldReceive('store')->once()->with($report->extension, Mockery::type('string'));

        Artisan::call('reports:handle', ['classReport' => TestReport::class]);

        $this->assertDatabaseHas('reports', [
            'class_name' => TestReport::class,
            'status' => ReportModel::STATUS_COMPLETED,
            'is_completed' => true,
        ]);
    }
}