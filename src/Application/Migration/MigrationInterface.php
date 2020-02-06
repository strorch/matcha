<?php
declare(strict_types=1);


namespace App\Application\Migration;


interface MigrationInterface
{
    public function up(): void;
    public function down(): void;
}
