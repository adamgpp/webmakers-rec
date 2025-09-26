<?php

declare(strict_types=1);

namespace App\Module\Finance\Domain\ValueObject;

use App\Modules\Core\Domain\ValueObject\Exception\ValueValidationException;

final readonly class Amount
{
    public function __construct(public int $value)
    {
        if (0 >= $this->value) {
            throw ValueValidationException::withMessage('Amount must be greater than 0.');
        }
    }
}
