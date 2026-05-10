<?php

declare(strict_types=1);

namespace App\Core\Database;

use PDO;
use PDOException;
use PDOStatement;
use RuntimeException;

final class Database
{
    private static ?self $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $config = require dirname(__DIR__, 3) . '/config/database.php';

        $dns = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['dbname'],
            $config['charset']
        );

        try {
            $this->connection = new PDO(
                $dns,
                $config['username'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            throw new RuntimeException('Database connection failed. ', 0, $e);
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function connection(): PDO
    {
        return $this->connection;
    }

    public function query(string $sql, array $params = []): PDOStatement
    {
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);

        return $statement;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function fetchOne(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetch();

        return $result === false ? null : $result;
    }
}
