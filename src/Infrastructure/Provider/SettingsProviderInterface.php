<?php
declare(strict_types=1);

namespace App\Infrastructure\Provider;

interface SettingsProviderInterface
{
    public function getSettings(): array;

    public function getSettingByName(string $name);
}
