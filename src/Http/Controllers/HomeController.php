<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        if (class_exists(config('reports.middleware'))) {
            $this->middleware(config('reports.middleware'));
        }
    }

    /**
     * @return View
     */
    public function index() : View
    {
        return view('reports::app');
    }
}