<?php

namespace App\Core\User\Domain\Notification;

interface NotificationUserInterface
{
    public function sendEmail(string $recipient, string $subject, string $message): void;
}
