<?php

declare(strict_types=1);

namespace App\Module\Finance\Domain\Service\Contractor;

use App\Module\Core\Domain\Repository\WarningRepositoryInterface;
use App\Module\Core\Domain\Service\WarningGenerationInterface;
use Symfony\Component\Uid\Ulid;

final readonly class ContractorsWithDebtWarningGenerator implements WarningGenerationInterface
{
    public function __construct(
        private WarningRepositoryInterface $warningRepository,
    ) {
    }

    public function generate(Ulid $warningSubjectId, \DateTimeImmutable $generatedAt): void
    {
        // @todo implement
    }
}
