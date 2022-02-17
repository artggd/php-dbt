<?php

declare(strict_types=1);

namespace PhpDbt\Framework\Test;

use PhpDbt\Framework\Test\Action\Action;
use PhpDbt\Framework\Test\Action\Result\ActionResult;
use PhpDbt\Framework\Test\Assertion\Assertion;
use Twig\Environment;

final class Test
{
    private ActionResult $actionResult;

    public function __construct(
        private \PDO $pdo,
        private Environment $twig,
    ) {}

    public function given(string $given): self
    {
        $this->pdo->exec($given);

        return $this;
    }

    public function when(Action $action): self
    {
        // @todo make sure 'given' was called
        $this->actionResult = $action($this->pdo, $this->twig);

        return $this;
    }

    public function then(Assertion ...$assertions): void
    {
        // @todo make sure 'when' was called
        foreach ($assertions as $assertion) {
            // @todo catch exceptions
            if ($assertion($this->actionResult, $this->pdo)) {
                die('passed!');
            }

            die('failed!');
        }
    }
}
