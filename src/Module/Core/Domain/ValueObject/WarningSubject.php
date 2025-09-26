<?php

declare(strict_types=1);

namespace App\Module\Core\Domain\ValueObject;

use App\Module\Core\Domain\Entity\WarningSubjectTypeEnum;
use Symfony\Component\Uid\Ulid;

final readonly class WarningSubject
{
    public function __construct(public Ulid $id, public WarningSubjectTypeEnum $type)
    {
    }
}
