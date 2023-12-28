<?php

namespace App\Core\User\Infrastructure\Notification\Email;

use App\Common\Mailer\SMPTMailer;
use App\Core\User\Domain\Notification\NotificationUserInterface;

class Mailer implements NotificationUserInterface
{
    public function __construct(private readonly SMPTMailer $SMPTMailer)
    {
    }

    public function sendEmail(string $recipient, string $subject, string $message): void
    {
        $this->SMPTMailer->send($recipient, $subject, $message);
    }
}
