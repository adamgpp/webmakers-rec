<?php

declare(strict_types=1);

namespace App\Module\Core\Application\Bus;

interface CommandBusInterface
{
    public function dispatch(SyncCommandInterface $command): void;
}
