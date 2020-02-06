<?php


namespace App\Application\Migration;


interface MigrationInterface
{
    public function up(): bool;
    public function down(): bool;
}
