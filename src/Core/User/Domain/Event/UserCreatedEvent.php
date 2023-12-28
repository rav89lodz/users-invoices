<?php

namespace App\Core\User\Domain\Event;

class UserCreatedEvent extends AbstractUserEvent
{
    public function sendEmailToUser(): bool
    {
        // $this->user->getUser()->getEmail();
        return true;
    }
}
