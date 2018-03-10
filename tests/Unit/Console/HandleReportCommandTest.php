<?php
declare(strict_types=1);

namespace agoalofalife\Tests\Unit\Console;

use agoalofalife\Tests\Support\FakeReport\TestReport;
use agoalofalife\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class HandleReportCommandTest extends TestCase
{
    public function testHandle() : void
    {
        $this->expectException('test class not exist');
        Artisan::call('reports:handle', ['classReport' => 'Test\\S']);
//        dd(Artisan::output());
//        $this->assertRegExp('/Publishing complete/', Artisan::output());
    }
}