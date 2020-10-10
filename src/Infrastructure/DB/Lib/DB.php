<?php
declare(strict_types=1);

namespace App\Infrastructure\DB\Lib;


use App\Infrastructure\Provider\SettingsProviderInterface;
use PDO;

final class DB
{
    private array $dbParams;

    private PDO $pdo;

    public function __construct(SettingsProviderInterface $settingsProvider)
    {
        $this->dbParams = $settingsProvider->getSettingByName('dbParams');
        $this->pdo = $this->initPdo();
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    private function initPdo(): PDO
    {
        $pdo = new PDO($this->getDSN(), $this->getUser(), $this->getPassword());
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }

    public function exec(string $command, array $params = []): void
    {
        if (empty($params)) {
            $this->pdo->exec($command);
            return;
        }
        $prepared = $this->pdo->prepare($command);
        $prepared->execute($params);
    }

    public function query(string $command, array $params = []): ?array
    {
        if (empty($params)) {
            $prepared = $this->pdo->query($command);
        } else {
            $prepared = $this->pdo->prepare($command);
            $prepared->execute($params);
        }

        return $prepared->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getDSN(): string
    {
        $params = $this->dbParams;

        return "{$params['type']}:host={$params['host']};dbname={$params['dbName']};port={$params['port']}";
    }

    private function getUser(): string
    {
        return $this->dbParams['user'];
    }

    private function getPassword(): string
    {
        return $this->dbParams['password'];
    }
}
