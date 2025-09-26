<?php

declare(strict_types=1);

namespace App\Module\Finance\Domain\Entity;

use App\Module\Finance\Domain\ValueObject\Amount;
use App\Modules\Core\Domain\ValueObject\BaseString;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity]
#[ORM\Table(
    name: 'invoices'
)]
#[ORM\UniqueConstraint(name: 'contractor_id_invoice_unique_number_unique', columns: ['contractor_id', 'unique_number'])]
final class Invoice
{
    #[ORM\Id]
    #[ORM\Column(type: 'ulid', unique: true)]
    private Ulid $id;

    #[ORM\Column]
    private string $uniqueNumber;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $paidAt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $paymentDueDate;

    #[ORM\Column]
    private int $amount;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Contractor::class, inversedBy: 'invoices')]
    #[ORM\JoinColumn(nullable: false)]
    private Contractor $contractor;

    public function __construct(
        Ulid $id,
        BaseString $uniqueNumber,
        Amount $price,
        \DateTimeImmutable $paymentDueDate,
        Contractor $contractor,
        \DateTimeImmutable $createdAt,
    ) {
        $this->id = $id;
        $this->uniqueNumber = (string) $uniqueNumber;
        $this->amount = $price->value;
        $this->paymentDueDate = $paymentDueDate;
        $this->contractor = $contractor;
        $this->createdAt = $createdAt;
        $this->updatedAt = $createdAt;
    }
}
