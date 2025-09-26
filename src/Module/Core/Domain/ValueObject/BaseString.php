<?php

declare(strict_types=1);

namespace App\Module\Core\Domain\ValueObject;

use App\Module\Core\Domain\ValueObject\Exception\ValueValidationException;

final readonly class BaseString implements \Stringable
{
    private const MIN_LENGTH = 1;
    private const MAX_LENGTH = 255;

    public function __construct(public string $value)
    {
        if (strlen($this->value) < self::MIN_LENGTH) {
            throw ValueValidationException::withMessage(sprintf('BaseString length cannot be lower than %s character.', self::MIN_LENGTH));
        }

        if (strlen($this->value) > self::MAX_LENGTH) {
            throw ValueValidationException::withMessage(sprintf('BaseString length cannot be greater than %s characters.', self::MAX_LENGTH));
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
