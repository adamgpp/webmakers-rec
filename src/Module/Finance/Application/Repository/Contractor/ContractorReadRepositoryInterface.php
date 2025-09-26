<?php

declare(strict_types=1);

namespace App\Module\Finance\Application\Repository\Contractor;

use App\Module\Finance\Domain\ValueObject\Amount;
use Symfony\Component\Uid\Ulid;

interface ContractorReadRepositoryInterface
{
    /**
     * @return list<Ulid>
     */
    public function findContractorIdsWithDebtGreaterThan(Amount $debt, \DateTimeImmutable $paymentDueDate): array;
}
