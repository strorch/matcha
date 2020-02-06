<?php

namespace App\migrations;

use App\Application\Migration\AbstractMigration;

class migration_init extends AbstractMigration
{
    /**
     * @inheritDoc
     */
    public static $files = [
        'init',
    ];

    /**
     * @inheritDoc
     */
    public static $filesDir = 'sql';
}
