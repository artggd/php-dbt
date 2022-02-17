<?php

$pdo = new \PDO('sqlite:/app/database_test.sqlite');
$pdo->query(
    <<<SQL
        CREATE TABLE IF NOT EXISTS posts ( 
            id    INTEGER PRIMARY KEY,
            title VARCHAR(250)
        );
        SQL
);
