<?php
declare(strict_types=1);

namespace agoalofalife\Tests\Feature\Http\Controllers;

use agoalofalife\Tests\TestCase;
use Illuminate\Routing\Console\MiddlewareMakeCommand;

class HomeControllerTest extends TestCase
{
    public function testClassExistMiddleware() : void
    {
        config(['reports.middleware' => MiddlewareMakeCommand::class]);
//        app('config')->set('reports.middleware', MiddlewareMakeCommand::class);
        $this->get('/reports/');
    }
    public function testIndex() : void
    {
        $this->get('/reports/');
    }
}