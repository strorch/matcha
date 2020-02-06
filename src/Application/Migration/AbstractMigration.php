<?php
declare(strict_types=1);


namespace App\Application\Migration;

use App\Infrastructure\DB\DB;
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
    protected static $files = [];

    /**
     * @var string|null
     */
    protected static $filesDir;

    /**
     * @var DB
     */
    protected $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /**
     * @inheritDoc
     */
    public function up(): bool
    {
        $pdo = $this->db->getPDO();
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);

        foreach (static::$files as $file) {
            $filePath = __DIR__ . '/' . static::$filesDir . '/' . $file;
            $sqlRow = file_get_contents($filePath);
            if (empty($sqlRow)) {
                throw new InvalidFileException('File not found');
            }
            $this->db->exec($sqlRow);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function down(): bool
    {
        return true;
    }
}
