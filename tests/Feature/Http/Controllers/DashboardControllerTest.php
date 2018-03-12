<?php
declare(strict_types=1);

namespace agoalofalife\Tests\Feature\Http\Controllers;

use agoalofalife\Reports\Models\Report;
use agoalofalife\Tests\Support\FakeReport\TestReport;
use agoalofalife\Tests\Support\FakeReport\TestReportNotNotification;
use agoalofalife\Tests\TestCase;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Support\Facades\Storage;

/**
 * Class DashboardControllerTest
 * @package agoalofalife\Tests\Feature\Http\Controllers
 */
class DashboardControllerTest extends TestCase
{
    use InteractsWithDatabase;

    protected $fakeReportClass = TestReport::class;
    protected $fakeReportClassWithoutNotif = TestReportNotNotification::class;

    public function testTableColumnLocalEn() : void
    {
        $this->get('reports/api/dashboard.table.column')
            ->assertJson(trans("reports::dashboard"));
    }

    public function testGetReportsIsEmpty() : void
    {
        $this->get('reports/api/dashboard.reports')->assertJson([
            'data' => []
        ]);
    }

    public function testGetReports() : void
    {
        config(['reports.reports' => [
            $this->fakeReportClass
        ]]);
        $report = app()->make($this->fakeReportClass);

        $this->get('reports/api/dashboard.reports')->assertJson([
            'data' => [
            [
                  "name" => $report->getTitle(),
                  "description" => $report->getDescription(),
                  "class" => $this->fakeReportClass,
                  "path" => null,
                  "lastModified" => null,
                  "isCompleted" => false,
                  "status" => Report::STATUS_NEW,
                  "notifications" => ['mail']
            ]
            ]
        ]);
    }

    public function testGetReportsWithoutNotifications() : void
    {
        config(['reports.reports' => [
            $this->fakeReportClassWithoutNotif
        ]]);

        $report = app()->make($this->fakeReportClassWithoutNotif);

        $this->get('reports/api/dashboard.reports')->assertJson([
            'data' => [
                [
                    "name" => $report->getTitle(),
                    "description" => $report->getDescription(),
                    "class" => $this->fakeReportClassWithoutNotif,
                    "path" => null,
                    "lastModified" => null,
                    "isCompleted" => false,
                    "status" => Report::STATUS_NEW,
                    "notifications" => []
                ]
            ]
        ]);
    }

    public function testGetNotificationCountZero() : void
    {
        $this->get('reports/api/dashboard.reports.notificationCount')->assertJson([
            'data' => [
                'count' => 0
            ]
        ]);
    }

    public function testGetNotificationCountIsNotZero() : void
    {
        $randomInt = $this->faker()->randomDigit;
        factory(Report::class, $randomInt)->create([
           'is_completed' => true
        ]);

        $this->get('reports/api/dashboard.reports.notificationCount')->assertJson([
            'data' => [
                'count' => $randomInt
            ]
        ]);
    }

    public function testUpdateReport() : void
    {
        factory(Report::class)->create([
            'class_name' => TestReport::class
        ]);
        $this->post('reports/api/dashboard.reports.update', [
            'class' => TestReport::class
        ])->assertJson([
            'data' => [
                'status' => 'success'
            ]
        ]);

        $this->assertDatabaseHas('reports', [
            'class_name' => TestReport::class,
            'status' => Report::STATUS_PROCESS,
        ]);
    }

    public function testDownloadFileClassNotExist() : void
    {
        $this->get('reports/api/dashboard.file.download/' . $this->faker()->word)->assertStatus(500);
    }

    public function testDownloadFile() : void
    {
        $report = app()->make(TestReport::class);
        factory(Report::class)->create([
            'class_name' => TestReport::class
        ]);

        $fileSystem = $this->mock(Filesystem::class);
        $fileSystem->shouldReceive('download')->once()->with($report->getFileNormalize());
        Storage::shouldReceive('disk')->with($report->disk)->once()->andReturn($fileSystem);

        $className = str_replace('\\', '@', TestReport::class);
        $this->get('reports/api/dashboard.file.download/' . $className)->assertStatus(200);

        $this->assertDatabaseHas('reports', [
            'class_name' => TestReport::class,
            'is_completed' => false,
        ]);
    }
}