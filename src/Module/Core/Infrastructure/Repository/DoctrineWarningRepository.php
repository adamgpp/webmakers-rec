<?php

declare(strict_types=1);

namespace App\Module\Core\Infrastructure\Repository;

use App\Module\Core\Domain\Entity\Warning;
use App\Module\Core\Domain\Repository\WarningRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineWarningRepository implements WarningRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function add(Warning $warning): void
    {
        $this->entityManager->persist($warning);
    }
}
