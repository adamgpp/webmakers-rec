<?php

declare(strict_types=1);

namespace App\Module\Finance\Domain\Service\Invoice;

use App\Module\Core\Domain\Repository\WarningRepositoryInterface;
use App\Module\Core\Domain\Service\WarningGenerationInterface;
use Symfony\Component\Uid\Ulid;

final readonly class OverdueInvoicesWarningGenerator implements WarningGenerationInterface
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
