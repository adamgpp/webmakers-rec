<?php

declare(strict_types=1);

namespace App\Module\Finance\Domain\Entity;

use App\Module\Core\Domain\ValueObject\BaseString;
use App\Module\Finance\Domain\ValueObject\Amount;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity]
#[ORM\Table(name: 'budgets')]
final class Budget
{
    #[ORM\Id]
    #[ORM\Column(type: 'ulid', unique: true)]
    private Ulid $id;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private int $balance = 0;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    public function __construct(
        Ulid $id,
        BaseString $name,
        \DateTimeImmutable $createdAt,
    ) {
        $this->id = $id;
        $this->name = $name->value;
        $this->createdAt = $createdAt;
        $this->updatedAt = $createdAt;
    }

    public function getId(): Ulid
    {
        return $this->id;
    }

    public function getMoney(Amount $amount, \DateTimeImmutable $doneAt): void
    {
        $this->balance = $this->balance - $amount->value;
        $this->updatedAt = $doneAt;
    }

    public function addMoney(Amount $amount, \DateTimeImmutable $doneAt): void
    {
        $this->balance = $this->balance + $amount->value;
        $this->updatedAt = $doneAt;
    }
}
