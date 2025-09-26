<?php

declare(strict_types=1);

namespace App\Module\Core\Application\Command;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GenerateWarningHandler
{
    public function __construct()
    {
    }

    public function __invoke(GenerateWarningCommand $command): void
    {
        // @todo fetch subject ulids
        // @todo generate warnings
    }
}
