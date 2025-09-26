<?php

declare(strict_types=1);

namespace App\Module\Core\Domain\Service;

use Symfony\Component\Uid\Ulid;

interface WarningGenerationInterface
{
    public function generate(
        Ulid $warningSubjectId,
        \DateTimeImmutable $generatedAt,
    ): void;
}
