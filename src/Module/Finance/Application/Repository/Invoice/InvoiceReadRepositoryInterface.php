<?php

declare(strict_types=1);

namespace App\Module\Finance\Application\Repository\Invoice;

use Symfony\Component\Uid\Ulid;

interface InvoiceReadRepositoryInterface
{
    /**
     * @return list<Ulid>
     */
    public function findOverdueInvoiceIds(\DateTimeImmutable $paymentDueDate): array;
}
