<?php

namespace App\Core\User\Application\EventListener;

use App\Core\User\Domain\Event\UserCreatedEvent;
use App\Core\User\Domain\Notification\NotificationUserInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SendEmailUserCreatedEventSubscriberListener implements EventSubscriberInterface
{
    public function __construct(private readonly NotificationUserInterface $mailer)
    {
    }

    public function send(UserCreatedEvent $event): void
    {
        $this->mailer->sendEmail(
            $event->sendEmailToUser(),
            'Utworzono Użytkownika',
            'Zarejestrowano konto w systemie. Aktywacja konta trwa do 24h'
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserCreatedEvent::class => 'send'
        ];
    }
}
