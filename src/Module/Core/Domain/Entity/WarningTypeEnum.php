<?php

declare(strict_types=1);

namespace App\Module\Core\Domain\Entity;

enum WarningTypeEnum: string
{
    case CONTRACTORS_DEBT = 'contractors_debt';
    case OVERDUE_INVOICES = 'overdue_invoices';
    case NEGATIVE_BUDGET = 'negative_budget';
}
