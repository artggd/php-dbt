<?php

declare(strict_types=1);

namespace PhpDbt\UI;

use PhpDbt\Framework\Test\Action\ExecuteQuery;
use PhpDbt\Framework\Test\Assertion\AssertEquals;
use PhpDbt\Framework\Test\Test;
use PhpDbt\UI\Configuration\Configuration;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

final class Application
{
    public static function main(): int
    {
        return (new self)->run($_SERVER['argv']);
    }

    private Configuration $config;

    private Environment $twig;

    private function initTwigEnvironment(): void
    {
        $loader = new FilesystemLoader();
        $loader->addPath($this->config->getQueryPath(), 'queries');
        $loader->addPath($this->config->getTestsPath(), 'tests');

        $this->twig = new Environment($loader, [
            'debug' => true,
            'autoescape' => false,
            'strict_variables' => true
        ]);
    }

    private function loadConfiguration(array $argv): void
    {
        // @todo make this actually configurable
        $this->config = new Configuration(
            '/app/tests/app/queries',
            '/app/tests/app/tests',
            'sqlite:/app/database_test.sqlite',
            '/app/tests/app/tests/bootstrap.php',
        );
    }

    private function run($argv): int
    {
        $this->loadConfiguration($argv);
        $this->initTwigEnvironment();
        $this->runBootstrap();

        $pdo = new \PDO($this->config->getDsn());

        $pdo->beginTransaction();

        $this->twig->addFunction(
            new TwigFunction('db_test', fn() => new Test($pdo, $this->twig))
        );
        $this->twig->addFunction(
            new TwigFunction('execute_query', fn(string $queryPath) => new ExecuteQuery($queryPath))
        );
        $this->twig->addFunction(
            new TwigFunction('assert_equals', fn(string $query) => new AssertEquals($query))
        );

        // @todo find and loop through test templates
        $this->twig->render('@tests/select_posts_test.sql.twig');

        return 0;
    }

    private function runBootstrap(): void
    {
        $bootstrap = $this->config->getBootstrapFile();

        if ($bootstrap === null) {
            return;
        }
        if (file_exists($bootstrap) === false) {
            throw new \RuntimeException(sprintf('Bootsrap file %s not found.', $bootstrap));
        }
        include $bootstrap;
    }
}
