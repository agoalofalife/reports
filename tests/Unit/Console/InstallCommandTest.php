<?php
declare(strict_types=1);

namespace agoalofalife\Tests\Unit\Console;

use agoalofalife\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

/**
 * Class InstallCommandTest
 * @package agoalofalife\Tests\Unit\Console
 */
class InstallCommandTest extends TestCase
{
    public function testHandle() : void
    {
        Artisan::call('reports:install');
    }
}