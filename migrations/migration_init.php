<?php
declare(strict_types=1);

namespace App\migrations;

use App\Application\Migration\AbstractMigration;

final class migration_init extends AbstractMigration
{
    /**
     * @inheritDoc
     */
    public static $files = [
        'init.sql',
    ];

    /**
     * @inheritDoc
     */
    public static $filesDir = 'sql';
}