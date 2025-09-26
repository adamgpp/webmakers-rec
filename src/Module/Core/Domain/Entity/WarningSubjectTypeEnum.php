<?php

declare(strict_types=1);

namespace App\Module\Core\Domain\Entity;

enum WarningSubjectTypeEnum: string
{
    case CONTRACTOR = 'contractor';
    case INVOICE = 'invoice';
    case BUDGET = 'budget';
}
