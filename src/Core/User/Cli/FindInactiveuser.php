<?php

namespace App\Core\User\Cli;

use App\Core\User\Application\Query\GetInactiveUsers\GetInactiveUsersQuery;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

#[AsCommand(
    name: 'app:user:find-inactive',
    description: 'Szukanie nieaktywnych użytkowników'
)]
class FindInactiveuser extends Command
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->bus->dispatch(new GetInactiveUsersQuery())->last(HandledStamp::class);

        /** @var UserDTO $invoice */
        foreach ($users->getResult() as $user) {
            $output->writeln($user->email);
        }

        return Command::SUCCESS;
    }
}