<?php

declare(strict_types=1);

namespace App\Module\Core\Domain\Entity;

use App\Module\Core\Domain\ValueObject\WarningSubject;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity]
#[ORM\Table(name: 'warnings')]
final class Warning
{
    #[ORM\Id]
    #[ORM\Column(type: 'ulid', unique: true)]
    private Ulid $id;

    #[ORM\Column(type: 'ulid')]
    private Ulid $subjectId;

    #[ORM\Column(enumType: WarningSubjectTypeEnum::class)]
    private WarningSubjectTypeEnum $subjectType;

    #[ORM\Column(enumType: WarningTypeEnum::class)]
    private WarningTypeEnum $type;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $deletedAt = null;

    public function __construct(
        Ulid $id,
        WarningSubject $warningSubject,
        WarningTypeEnum $type,
        \DateTimeImmutable $createdAt,
    ) {
        $this->id = $id;
        $this->subjectId = $warningSubject->id;
        $this->subjectType = $warningSubject->type;
        $this->type = $type;
        $this->createdAt = $createdAt;
        $this->updatedAt = $createdAt;
    }
}
