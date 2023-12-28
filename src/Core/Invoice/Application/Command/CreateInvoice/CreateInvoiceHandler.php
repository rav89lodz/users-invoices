<?php

namespace App\Core\Invoice\Application\Command\CreateInvoice;

use App\Core\Invoice\Domain\Invoice;
use App\Core\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use App\Core\User\Domain\Exception\UserInactiveException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateInvoiceHandler
{
    public function __construct(
        private readonly InvoiceRepositoryInterface $invoiceRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(CreateInvoiceCommand $command): void
    {
        $user = $this->checkUserIsActive($command->email);
        if($user instanceof User)
        {
            $this->invoiceRepository->save(new Invoice(
                $user,
                $command->amount
            ));
    
            $this->invoiceRepository->flush();
        }
    }

    private function checkUserIsActive($email): User|null
    {
        $user = $this->userRepository->getByEmail($email);
        if($user->isActive())
        {
            return $user;
        }
        throw new UserInactiveException("Użytkownik jest nieaktywny");
    }
}
