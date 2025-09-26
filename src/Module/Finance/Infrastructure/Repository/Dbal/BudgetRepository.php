<?php

declare(strict_types=1);

namespace App\Module\Finance\Infrastructure\Repository\Dbal;

use App\Module\Finance\Application\Repository\Budget\BudgetReadRepositoryInterface;
use Doctrine\DBAL\Connection;

final readonly class BudgetRepository implements BudgetReadRepositoryInterface
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function findNegativeBudgets(): array
    {
        // TODO: Implement findNegativeBudgets() method.
        return [];
    }
}
