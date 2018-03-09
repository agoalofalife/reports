<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('dashboard.table.column', 'DashboardController@tableColumn');
    Route::get('dashboard.reports', 'DashboardController@getReports');
    Route::get('dashboard.reports.notificationCount', 'DashboardController@getNotificationCount');
    Route::post('dashboard.reports.update', 'DashboardController@updateReport');
    Route::get('dashboard.file.download/{report}', 'DashboardController@downloadFile');
});

Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)');