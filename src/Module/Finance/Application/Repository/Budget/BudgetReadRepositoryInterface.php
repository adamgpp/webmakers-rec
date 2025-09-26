<?php

declare(strict_types=1);

namespace App\Module\Finance\Application\Repository\Budget;

use Symfony\Component\Uid\Ulid;

interface BudgetReadRepositoryInterface
{
    /**
     * @return list<Ulid>
     */
    public function findNegativeBudgets(): array;
}
