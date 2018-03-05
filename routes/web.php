<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('dashboard.table.column', 'DashboardController@tableColumn');
    Route::get('dashboard.table.formColumn', 'DashboardController@formColumn');
    Route::get('dashboard.table.tasks', 'DashboardController@index');
    Route::get('dashboard.table.users', 'DashboardController@users');
    Route::get('dashboard.table.statuses', 'DashboardController@statuses');
    Route::get('dashboard.table.listMode', 'DashboardController@listMode');
    Route::post('dashboard.table.tasks.create', 'DashboardController@createTask');
    Route::put('dashboard.table.tasks.update', 'DashboardController@updateTask');
    Route::delete('dashboard.table.tasks.remove/{id}', 'DashboardController@remove');
});

Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)');