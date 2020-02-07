<?php
declare(strict_types=1);

namespace App\Infrastructure\DB;


use PDO;
use PDOException;

final class DB
{
    /**
     * @var string[]
     */
    private $dbParams;

    /**
     * @var PDO
     */
    private $connection;

    /**
     * DB constructor.
     * @param string[] $dbParams
     */
    private function __construct(array $dbParams)
    {
        $this->dbParams = $dbParams;
        $this->validateParams();
    }

    /**
     * @param string[] $dbParams
     * @return DB
     */
    public static function get(array $dbParams): self
    {
        $DB = new static($dbParams);

        $DB->connection = new PDO($DB->getDSN(), $DB->getUser(), $DB->getPassword());
        $DB->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $DB->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $DB;
    }

    /**
     * @return PDO
     */
    public function getPDO()
    {
        return $this->connection;
    }

    /**
     * @param string $command
     * @param array $params
     */
    public function exec(string $command, array $params = []): void
    {
        if (empty($params)) {
            $this->connection->exec($command);
            return;
        }
        $prepared = $this->connection->prepare($command);
        $prepared->execute($params);
    }

    /**
     * @param string $command
     * @param array $params
     * @return array|null
     */
    public function query(string $command, array $params = []): ?array
    {
        if (empty($params)) {
            $res = $this->connection->query($command);
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }
        $prepared = $this->connection->prepare($command);
        $prepared->execute($params);
        return $prepared->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return string
     */
    private function getDSN(): string
    {
        $params = $this->dbParams;
        return "{$params['type']}:host={$params['host']};dbname={$params['dbName']};port={$params['port']}";
    }

    /**
     * @return string
     */
    private function getUser(): string
    {
        return $this->dbParams['user'];
    }

    /**
     * @return string
     */
    private function getPassword(): string
    {
        return $this->dbParams['password'];
    }

    /**
     * Validates the connection params exists
     */
    private function validateParams(): void
    {
        foreach (['type', 'host', 'port', 'dbName', 'user', 'password'] as $value) {
            if (empty($this->dbParams[$value])) {
                throw new PDOException("DB param '$value' is empty");
            }
        }
    }
}
