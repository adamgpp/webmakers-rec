<?php

declare(strict_types=1);

namespace App\Module\Finance\Infrastructure\Repository\Dbal;

use App\Module\Finance\Application\Repository\Contractor\ContractorReadRepositoryInterface;
use App\Module\Finance\Domain\ValueObject\Amount;
use Doctrine\DBAL\Connection;

final readonly class ContractorRepository implements ContractorReadRepositoryInterface
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function findContractorsWithDebtGreaterThan(Amount $debt): array
    {
        // TODO: Implement findContractorsWithDebtMoreThan() method.
        return [];
    }
}
