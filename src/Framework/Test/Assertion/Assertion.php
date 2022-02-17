<?php

declare(strict_types=1);

namespace PhpDbt\Framework\Test\Assertion;

use PhpDbt\Framework\Test\Action\Result\ActionResult;

interface Assertion
{
    public function __invoke(ActionResult $actionResult, \PDO $pdo): bool;
}
