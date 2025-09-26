<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Module\Core\Domain\ValueObject\BaseString;
use App\Module\Core\Presentation\Cli\GenerateWarningsCommand;
use App\Module\Finance\Domain\Entity\Budget;
use App\Module\Finance\Domain\Entity\Contractor;
use App\Module\Finance\Domain\Entity\Invoice;
use App\Module\Finance\Domain\ValueObject\Amount;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Uid\Ulid;

final class GenerateWarningsCommandTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    private function runCommand(): string
    {
        $command = self::getContainer()->get(GenerateWarningsCommand::class);
        $tester = new CommandTester($command);
        $exitCode = $tester->execute([]);
        self::assertSame(0, $exitCode);

        return $tester->getDisplay();
    }

    public function testOverdueInvoiceIsDetected(): void
    {
        $today = new \DateTimeImmutable('today');
        $contractor = new Contractor(new Ulid(), 'ACME Sp. z o.o.', $today);
        $this->entityManager->persist($contractor);

        $invoice = new Invoice(
            new Ulid(),
            new BaseString('INV-OVERDUE'),
            new Amount(50000),
            $today->modify('- 7 days'),
            $contractor,
            $today
        );

        $this->entityManager->persist($invoice);
        $this->entityManager->flush();

        $output = $this->runCommand();

        self::assertStringContainsString($invoice->getId()->toBase32(), $output);
    }

    public function testInvoicePaidLateIsIgnored(): void
    {
        $today = new \DateTimeImmutable('today');
        $contractor = new Contractor(new Ulid(), 'Beta SA', $today);
        $this->entityManager->persist($contractor);

        $invoice = new Invoice(
            new Ulid(),
            new BaseString('INV-LATE'),
            new Amount(12345),
            $today->modify('-10 days'),
            $contractor,
            $today
        );

        $invoice->pay($today->modify('-2 days'));

        $this->entityManager->persist($invoice);
        $this->entityManager->flush();

        $output = $this->runCommand();

        self::assertStringNotContainsString($invoice->getId()->toBase32(), $output);
    }

    public function testContractorWithDebtAboveThresholdIsDetected(): void
    {
        $today = new \DateTimeImmutable('today');
        $contractor = new Contractor(new Ulid(), 'Giga Debt Sp. z o.o.', $today);
        $this->entityManager->persist($contractor);

        $invoice = new Invoice(
            new Ulid(),
            new BaseString('INV-DEBT'),
            new Amount(2_000_000),
            $today->modify('-1 day'),
            $contractor,
            $today
        );

        $this->entityManager->persist($invoice);
        $this->entityManager->flush();

        $output = $this->runCommand();

        self::assertStringContainsString($contractor->getId()->toBase32(), $output);
    }

    public function testNegativeBudgetIsDetected(): void
    {
        $today = new \DateTimeImmutable('today');
        $budget = new Budget(new Ulid(), new BaseString('Negative budget'), $today);
        $budget->getMoney(new Amount(1000));

        $this->entityManager->persist($budget);
        $this->entityManager->flush();

        $output = $this->runCommand();

        self::assertStringContainsString($budget->getId()->toBase32(), $output);
    }

    public function testPositiveBudgetIsIgnored(): void
    {
        $today = new \DateTimeImmutable('today');
        $budget = new Budget(new Ulid(), new BaseString('Positive budget'), $today);
        $budget->addMoney(new Amount(1000));

        $this->entityManager->persist($budget);
        $this->entityManager->flush();

        $output = $this->runCommand();

        self::assertStringNotContainsString($budget->getId()->toBase32(), $output);
    }
}
