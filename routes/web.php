<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('dashboard.table.column', 'DashboardController@tableColumn');
    Route::get('dashboard.reports', 'DashboardController@getReports');
});

Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)');