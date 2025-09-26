<?php

declare(strict_types=1);

namespace App\Module\Finance\Domain\Entity;

enum PaymentStatusEnum: string
{
    case AWAITING = 'awaiting';
    case PAID = 'paid';

    public static function values(): array
    {
        return array_map(static fn (self $self) => $self->value, self::cases());
    }
}
