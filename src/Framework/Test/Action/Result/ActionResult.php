<?php

declare(strict_types=1);

namespace PhpDbt\Framework\Test\Action\Result;

final class ActionResult
{
    public function __construct(private \PDOStatement $result)
    {
    }

    public function getResults(): array|false
    {
        return $this->result->fetchAll();
    }
}
