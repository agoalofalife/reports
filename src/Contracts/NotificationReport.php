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
     * Return email owner report
     * @return string
     */
    public function getOwnerEmail() : string;

    /**
     * Return class notification
     * @return Notification
     */
    public function getNotification() : Notification;
}