<?php

declare(strict_types=1);

namespace App\Module\Core\Domain\Repository;

use App\Module\Core\Domain\Entity\Warning;

interface WarningRepositoryInterface
{
    public function add(Warning $warning): void;
}
