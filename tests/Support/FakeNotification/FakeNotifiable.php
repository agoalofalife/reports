<?php
declare(strict_types=1);

namespace agoalofalife\Tests\Support\FakeNotification;

class FakeNotifiable
{
    public function routeNotificationForMail($notification)
    {
        return '';
    }
}