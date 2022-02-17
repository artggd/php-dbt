<?php

declare(strict_types=1);

namespace PhpDbt\Framework\Test\Action;

use PhpDbt\Framework\Test\Action\Result\ActionResult;
use Twig\Environment;

final class ExecuteQuery implements Action
{
    public function __construct(private string $queryPath)
    {
    }

    public function __invoke(\PDO $pdo, Environment $twig): ActionResult
    {
        return new ActionResult($pdo->query($twig->render($this->queryPath)));
    }
}
