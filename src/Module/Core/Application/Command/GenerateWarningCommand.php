<?php

declare(strict_types=1);

namespace App\Module\Core\Application\Command;

use App\Module\Core\Application\Bus\SyncCommandInterface;
use App\Module\Core\Domain\Entity\WarningTypeEnum;
use App\Module\Core\Domain\ValueObject\WarningSubject;

/**
 * @see GenerateWarningHandler
 */
final readonly class GenerateWarningCommand implements SyncCommandInterface
{
    public function __construct(
        public WarningTypeEnum $warningType,
        public WarningSubject $warningSubject,
        public \DateTimeImmutable $generatedAt,
    ) {
    }
}
