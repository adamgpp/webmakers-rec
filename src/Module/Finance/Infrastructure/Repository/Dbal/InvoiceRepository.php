<?php

declare(strict_types=1);

namespace App\Module\Finance\Infrastructure\Repository\Dbal;

use App\Module\Finance\Application\Repository\Invoice\InvoiceReadRepositoryInterface;
use Doctrine\DBAL\Connection;

final readonly class InvoiceRepository implements InvoiceReadRepositoryInterface
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function findOverdueInvoices(): array
    {
        // TODO: Implement findOverdueInvoices() method.
        return [];
    }
}
