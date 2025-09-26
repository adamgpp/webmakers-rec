<?php

declare(strict_types=1);

namespace App\Module\Finance\Infrastructure\Repository\Dbal;

use App\Module\Finance\Application\Repository\Budget\BudgetReadRepositoryInterface;
use Doctrine\DBAL\Connection;
use Symfony\Component\Uid\Ulid;

final readonly class BudgetRepository implements BudgetReadRepositoryInterface
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function findNegativeBudgetIds(): array
    {
        $qb = $this->connection->createQueryBuilder();

        $qb
            ->select('b.id')
            ->from('budgets', 'b')
            ->where('b.balance < 0');

        $binaryIds = $qb->executeQuery()->fetchFirstColumn();

        return array_map(static fn (string $binaryId): Ulid => Ulid::fromBinary($binaryId), $binaryIds);
    }
}
