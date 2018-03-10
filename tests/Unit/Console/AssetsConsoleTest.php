<?php
declare(strict_types=1);

namespace agoalofalife\Tests\Unit\Console;

use agoalofalife\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class AssetsConsoleTest extends TestCase
{
    public function testHandler() : void
    {
        Artisan::call('reports:assets');
        $this->assertRegExp('/Publishing complete/', Artisan::output());
    }
}