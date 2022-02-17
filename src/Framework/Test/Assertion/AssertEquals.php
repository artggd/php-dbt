<?php

declare(strict_types=1);

namespace PhpDbt\Framework\Test\Assertion;

use PhpDbt\Framework\Test\Action\Result\ActionResult;

final class AssertEquals implements Assertion
{
    public function __construct(private string $query)
    {
    }

    public function __invoke(ActionResult $actionResult, \PDO $pdo): bool
    {
        $expectedStmt = $pdo->query($this->query);

        return $expectedStmt->fetchAll() === $actionResult->getResults();
    }
}
