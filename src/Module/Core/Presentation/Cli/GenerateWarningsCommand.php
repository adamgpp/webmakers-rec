<?php

declare(strict_types=1);

namespace App\Module\Core\Presentation\Cli;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'app:warnings:generate')]
final class GenerateWarningsCommand extends Command
{
}
