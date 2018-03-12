<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Contracts;

use Illuminate\Notifications\Notification;

/**
 * Interface NotificationReport
 * @package agoalofalife\Reports\Contracts
 */
interface NotificationReport
{
    /**
     * Return Notifiable
     * Need implementation method routeNotificationFor...
     * @return object
     */
    public function getNotifiable();

    /**
     * Return class notification
     * @return Notification
     */
    public function getNotification() : Notification;
}