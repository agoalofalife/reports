<?php
require __DIR__.'/../../vendor/autoload.php';
$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);
$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);
return $app;