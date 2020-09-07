<?php
declare(strict_types=1);


namespace App\Application\Migration;

use App\Infrastructure\DB\Lib\DB;
use App\Infrastructure\Provider\SettingsProviderInterface;
use Dotenv\Exception\InvalidFileException;
use PDO;

/**
 * Class AbstractMigration
 * @package App\Application\Migration
 */
abstract class AbstractMigration implements MigrationInterface
{
    /**
     * @var string[]
     */
    protected static array $files = [];

    /**
     * @var string|null
     */
    protected static ?string $filesDir;

    /**
     * @var DB
     */
    protected DB $db;

    /**
     * @var SettingsProviderInterface
     */
    private SettingsProviderInterface $settingsProvider;

    public function __construct(DB $db, SettingsProviderInterface $settingsProvider)
    {
        $this->db = $db;
        $this->settingsProvider = $settingsProvider;
    }

    /**
     * @inheritDoc
     */
    public function up(): void
    {
        $pdo = $this->db->getPDO();
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
        $projectsDir = $this->settingsProvider->getSettingByName('projectDir');

        foreach (static::$files as $file) {
            $filePath = $projectsDir . '/migrations/' . static::$filesDir . '/' . $file;
            $sqlRow = file_get_contents($filePath);
            if (empty($sqlRow)) {
                throw new InvalidFileException('SQL file not found or empty');
            }
            $this->db->exec($sqlRow);
        }
    }

    /**
     * @inheritDoc
     */
    public function down(): void
    {
    }
}
