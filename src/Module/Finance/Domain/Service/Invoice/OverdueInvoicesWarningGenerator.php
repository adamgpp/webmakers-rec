<?php

declare(strict_types=1);

namespace App\Module\Finance\Domain\Service\Invoice;

use App\Module\Core\Domain\Entity\Warning;
use App\Module\Core\Domain\Entity\WarningSubjectTypeEnum;
use App\Module\Core\Domain\Entity\WarningTypeEnum;
use App\Module\Core\Domain\Repository\WarningRepositoryInterface;
use App\Module\Core\Domain\Service\WarningGenerationInterface;
use App\Module\Core\Domain\ValueObject\WarningSubject;
use Symfony\Component\Uid\Ulid;

final readonly class OverdueInvoicesWarningGenerator implements WarningGenerationInterface
{
    public function __construct(
        private WarningRepositoryInterface $warningRepository,
    ) {
    }

    public function generate(
        \DateTimeImmutable $generatedAt,
        Ulid ...$warningSubjectIds,
    ): void {
        foreach ($warningSubjectIds as $warningSubjectId) {
            $this->warningRepository->add(new Warning(
                new Ulid(),
                new WarningSubject($warningSubjectId, WarningSubjectTypeEnum::INVOICE),
                WarningTypeEnum::OVERDUE_INVOICES,
                $generatedAt,
            ));
        }
    }
}
