<?php
declare(strict_types=1);

namespace App\migrations;

use App\Application\Migration\AbstractMigration;

final class migration_init extends AbstractMigration
{
    /**
     * @inheritDoc
     */
    public static array $files = [
        'create.sql',
        'alter.sql',
        'functions.sql',
        'views.sql',
        'init.sql',
    ];

    /**
     * @inheritDoc
     */
    public static ?string $filesDir = 'sql';
}
