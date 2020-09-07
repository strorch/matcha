<?php
declare(strict_types=1);

namespace App\Infrastructure\DB\Lib;


use App\Infrastructure\Provider\SettingsProviderInterface;
use PDO;

final class DB
{
    /**
     * @var string[]
     */
    private array $dbParams;

    /**
     * @var PDO
     */
    private PDO $pdo;

    /**
     * DB constructor.
     * @param SettingsProviderInterface $settingsProvider
     */
    public function __construct(SettingsProviderInterface $settingsProvider)
    {
        $this->dbParams = $settingsProvider->getSettingByName('dbParams');
        $this->pdo = $this->initPdo();
    }

    /**
     * @return PDO
     */
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

    /**
     * @param string $command
     * @param array $params
     */
    public function exec(string $command, array $params = []): void
    {
        if (empty($params)) {
            $this->pdo->exec($command);
            return;
        }
        $prepared = $this->pdo->prepare($command);
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
            $prepared = $this->pdo->query($command);
        } else {
            $prepared = $this->pdo->prepare($command);
            $prepared->execute($params);
        }

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
}
