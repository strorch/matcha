<?php
declare(strict_types=1);

namespace App\Infrastructure\DB\Lib;


use App\Infrastructure\Provider\SettingsProviderInterface;
use PDO;

final class DB
{
    private PDO $pdo;

    public function __construct(SettingsProviderInterface $settingsProvider)
    {
        $this->checkEnvironmentVars();
    }

    private function checkEnvironmentVars()
    {
        foreach ([
             'DB_TYPE',
             'DB_HOST',
             'DB_NAME',
             'DB_USER',
             'DB_PASSWORD',
         ] as $var) {
            if (is_null(getenv($var))) {
                throw new \RuntimeException("missing db variable '$var'");
            }
        }
    }

    public function getPDO(): PDO
    {
        if (empty($this->pdo)) {
            $pdo = new PDO($this->getDSN(), $this->getUser(), $this->getPassword());
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo = $pdo;
        }

        return $this->pdo;
    }

    public function exec(string $command, array $params = []): void
    {
        if (empty($params)) {
            $this->getPDO()->exec($command);
            return;
        }
        $prepared = $this->getPDO()->prepare($command);
        $prepared->execute($params);
    }

    public function query(string $command, array $params = []): ?array
    {
        if (empty($params)) {
            $prepared = $this->getPDO()->query($command);
        } else {
            $prepared = $this->getPDO()->prepare($command);
            $prepared->execute($params);
        }

        return $prepared->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getDSN(): string
    {
        $params = [
            'type' => getenv('DB_TYPE'),
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_NAME'),
            'port' => getenv('DB_PORT'),
        ];

        return "{$params['type']}:host={$params['host']};dbname={$params['name']};port={$params['port']}";
    }

    private function getUser(): string
    {
        return getenv('DB_USER');
    }

    private function getPassword(): string
    {
        return getenv('DB_PASSWORD');
    }
}
