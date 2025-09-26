<?php

declare(strict_types=1);

namespace App\Module\Core\Presentation\Cli;

use App\Module\Core\Domain\Service\WarningGenerationInterface;
use App\Module\Finance\Application\Repository\Budget\BudgetReadRepositoryInterface;
use App\Module\Finance\Application\Repository\Contractor\ContractorReadRepositoryInterface;
use App\Module\Finance\Application\Repository\Invoice\InvoiceReadRepositoryInterface;
use App\Module\Finance\Domain\ValueObject\Amount;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Uid\Ulid;

#[AsCommand(name: 'app:warnings:generate')]
final class GenerateWarningsCommand extends Command
{
    public function __construct(
        private readonly ContractorReadRepositoryInterface $contractorReadRepository,
        private readonly InvoiceReadRepositoryInterface $invoiceReadRepository,
        private readonly BudgetReadRepositoryInterface $budgetReadRepository,
        private readonly WarningGenerationInterface $contractorsWithDebtWarningGenerator,
        private readonly WarningGenerationInterface $overdueInvoicesWarningGenerator,
        private readonly WarningGenerationInterface $negativeBudgetWarningGenerator,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $today = (new \DateTimeImmutable())->setTime(0, 0);

        $contractorsWithDept = $this->contractorReadRepository->findContractorIdsWithDebtGreaterThan(new Amount(15000 * 100), $today);
        $overdueInvoices = $this->invoiceReadRepository->findOverdueInvoiceIds($today);
        $negativeBudgets = $this->budgetReadRepository->findNegativeBudgetIds();

        try {
            $this->contractorsWithDebtWarningGenerator->generate($today, ...$contractorsWithDept);
            $this->overdueInvoicesWarningGenerator->generate($today, ...$overdueInvoices);
            $this->negativeBudgetWarningGenerator->generate($today, ...$negativeBudgets);
        } catch (\Throwable $exception) {
            $output->writeln('<error>'.sprintf('Error occurred: `%s`', $exception->getMessage()).'</error>');

            return Command::FAILURE;
        }

        $this->entityManager->flush();

        $output->writeln('<info>Contractors with debt warning generation complete!</info>');
        $output->writeln($this->idsAsJsonString(...$contractorsWithDept));

        $output->writeln('<info>Overdue invoices warning generation complete!</info>');
        $output->writeln($this->idsAsJsonString(...$overdueInvoices));

        $output->writeln('<info>Negative budgets warning generation complete!</info>');
        $output->writeln($this->idsAsJsonString(...$negativeBudgets));

        return Command::SUCCESS;
    }

    private function idsAsJsonString(Ulid ...$ids): string
    {
        return sprintf('IDs: %s', json_encode(array_map(static fn (Ulid $id): string => $id->toBase32(), $ids)));
    }
}
