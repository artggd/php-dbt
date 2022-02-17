<?php

declare(strict_types=1);

namespace PhpDbt\Framework\Test\Action;

use PhpDbt\Framework\Test\Action\Result\ActionResult;
use Twig\Environment;

interface Action
{
    public function __invoke(\PDO $pdo, Environment $twig): ActionResult;
}
