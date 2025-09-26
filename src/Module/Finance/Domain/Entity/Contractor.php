<?php

declare(strict_types=1);

namespace App\Module\Finance\Domain\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity]
#[ORM\Table(name: 'contractors')]
final class Contractor
{
    #[ORM\Id]
    #[ORM\Column(type: 'ulid', unique: true)]
    private Ulid $id;

    #[ORM\Column]
    private string $name;

    /**
     * @var Collection<int, Invoice>
     */
    #[ORM\OneToMany(targetEntity: Invoice::class, mappedBy: 'contractor', cascade: ['persist', 'remove'])]
    private Collection $invoices;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $deletedAt = null;

    public function __construct(
        Ulid $id,
        string $name,
        \DateTimeImmutable $createdAt,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $createdAt;
    }

    public function getId(): Ulid
    {
        return $this->id;
    }

    public function getInvoices(): array
    {
        return $this->invoices->toArray();
    }
}
