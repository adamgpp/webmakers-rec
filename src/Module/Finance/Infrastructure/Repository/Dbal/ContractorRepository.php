<?php

declare(strict_types=1);

namespace App\Module\Finance\Infrastructure\Repository\Dbal;

use App\Module\Finance\Application\Repository\Contractor\ContractorReadRepositoryInterface;
use App\Module\Finance\Domain\ValueObject\Amount;
use Doctrine\DBAL\Connection;
use Symfony\Component\Uid\Ulid;

final readonly class ContractorRepository implements ContractorReadRepositoryInterface
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function findContractorIdsWithDebtGreaterThan(Amount $debt, \DateTimeImmutable $paymentDueDate): array
    {
        $qb = $this->connection->createQueryBuilder();

        $qb
            ->select('i.contractor_id')
            ->from('invoices', 'i')
            ->where(
                $qb->expr()->or(
                    $qb->expr()->and(
                        $qb->expr()->isNull('i.paid_at'),
                        $qb->expr()->lt('i.payment_due_date', ':payment_due_date')
                    ),
                    $qb->expr()->lt('i.paid_at', 'i.payment_due_date')
                )
            )
            ->groupBy('i.contractor_id')
            ->having('SUM(i.amount) > :limit')
            ->setParameter('payment_due_date', $paymentDueDate->format('Y-m-d H:i:s'))
            ->setParameter('limit', $debt->value);

        $binaryIds = $qb->executeQuery()->fetchFirstColumn();

        return array_map(static fn (string $binaryId): Ulid => Ulid::fromBinary($binaryId), $binaryIds);
    }
}
