<?php

declare(strict_types=1);

namespace PhpDbt\UI\Configuration;

final class Configuration
{
    public function __construct(
        private string $queryPath,
        private string $testsPath,
        private string $dsn,
        private ?string $bootstrap = null,
    ) {}

    public function getBootstrapFile(): ?string
    {
        return $this->bootstrap;
    }

    public function getDsn(): string
    {
        return $this->dsn;
    }

    public function getQueryPath(): string
    {
        return $this->queryPath;
    }

    public function getTestsPath(): string
    {
        return $this->testsPath;
    }
}
