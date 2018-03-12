
<h1 align="center">REPORTS</h1>

<p align="center">
 <a href="https://scrutinizer-ci.com/g/agoalofalife/reports/?branch=master"><img src="https://scrutinizer-ci.com/g/agoalofalife/reports/badges/quality-score.png?b=master"></a>
 <a href="https://scrutinizer-ci.com/g/agoalofalife/reports/?branch=master"><img src="https://scrutinizer-ci.com/g/agoalofalife/reports/badges/coverage.png?b=master"></a>
 <a href="https://scrutinizer-ci.com/g/agoalofalife/reports/?branch=master"><img src="https://scrutinizer-ci.com/g/agoalofalife/reports/badges/build.png?b=master"></a>
 </p>
 
<p align="center"><img src="/docs/images/base.jpg"></p>


> Requirements :
PHP verison >= 7.1.0
Laravel version >= 5.5

### What is it?

This is package offers ready UI and some code, for reports. 

Reports will be with extensions: `pdf, xlxs, xls, csv` .

In the paradigm Laravel, we make reprots and write code. It's just!

### Install

```php
composer require agoalofalife/reports
```

```php
php artisan reports:install
```

### Locale

In file `config/app.php` select your language.

The package provides two languages:
- ru
- en

### Blade and UI

In your template, you need to paste the code

```php
  <body>
    @include('reports::app')
    ...
```

### Cron
You have to add cron, how separete process.

```php
// App\Console\Kernel
use agoalofalife\Reports\Console\ParseReportsCommand;

  $schedule->command(ParseReportsCommand::class)->everyMinute();
```

### The development process

You create new file report:

```php
php artisan make:report NameReport
```
Insert in config `config/reports.php` :
```php

  'reports' => [
          \App\Reports\TestReport::class
    ],
```

Fill the class:
```php
<?php
declare(strict_types=1);
namespace App\Reports;

use agoalofalife\Reports\Contracts\HandlerReport;
use agoalofalife\Reports\Report;

class TestReport extends Report implements HandlerReport
{
    /**
     * Disk for filesystem
     * @var string
     */
    public $disk = 'public';

  /**
     * Format export : xls, xlsx, pdf, csv
     * @var string
     */
    public $extension = 'xlsx';

     /**
     * Get file name
     * @return string
     */
    public function getFilename() : string
    {
        return 'TestReport';
    }

    /**
     * Get title report
     * @return string
     */
    public function getTitle() : string
    {
        return 'Test';
    }

    /**
     * Get description report
     * @return string
     */
    public function getDescription() : string
    {
        return 'Description test report';
    }

    /**
     * @param $excel
     * @return bool
     */
    public function handler($excel) : bool
    {
      $excel->sheet('Sheetname', function ($sheet) {
            $sheet->rows(array(
                array('test1', 'test2'),
                array('test3', 'test4')
            ));
        });
      return true;
    }
}
```
Property `$disk`, name disk in filesystem.

Property `$extension`, type extension your file.

Method `getFilename` accordingly return name file.

Method `getTitle` return name title in UI.

Method `getDescription` return description in UI.

Method `handler` is base method. Package use [external](https://github.com/Maatwebsite/Laravel-Excel) package.

Method is a small wrapper.


### Notification

Once the report is ready, you can send [notification](https://laravel.com/docs/5.5/notifications).

For this you need to implement interface `agoalofalife\Reports\Contracts\NotificationReport`.

Method `getNotifiable` return `notifiable`, which has a method `routeNotificationFor`.

And method `getNotification`, return `Notification` type.
```php
    // implements agoalofalife\Reports\Contracts\NotificationReport
    public function getNotifiable()
    {
        return User::where('email', 'test@gmail.com')->get()->first();
    }

    public function getNotification(): Notification
    {
        return new InvoicePaid();
    }
```