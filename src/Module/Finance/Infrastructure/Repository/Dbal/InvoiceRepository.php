<?php

declare(strict_types=1);

namespace App\Module\Finance\Infrastructure\Repository\Dbal;

use App\Module\Finance\Application\Repository\Invoice\InvoiceReadRepositoryInterface;
use Doctrine\DBAL\Connection;
use Symfony\Component\Uid\Ulid;

final readonly class InvoiceRepository implements InvoiceReadRepositoryInterface
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function findOverdueInvoiceIds(\DateTimeImmutable $paymentDueDate): array
    {
        $qb = $this->connection->createQueryBuilder();

        $qb
            ->select('i.id')
            ->from('invoices', 'i')
            ->where('i.paid_at IS NULL')
            ->andWhere('i.payment_due_date < :payment_due_date')
            ->setParameter('payment_due_date', $paymentDueDate->format('Y-m-d H:i:s'));

        $binaryIds = $qb->executeQuery()->fetchFirstColumn();

        return array_map(static fn (string $binaryId): Ulid => Ulid::fromBinary($binaryId), $binaryIds);
    }
}
