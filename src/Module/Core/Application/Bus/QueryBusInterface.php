<?php

declare(strict_types=1);

namespace App\Module\Core\Application\Bus;

interface QueryBusInterface
{
    public function dispatch(QueryInterface $query): mixed;
}
