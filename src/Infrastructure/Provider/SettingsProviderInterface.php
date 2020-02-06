<?php
declare(strict_types=1);

namespace App\Infrastructure\Provider;

/**
 * Interface SettingsProviderInterface
 * @package App\Infrastructure\Provider
 */
interface SettingsProviderInterface
{
    /**
     * @return array
     */
    public function getSettings(): array;

    /**
     * @param string $name
     * @return mixed
     */
    public function getSettingByName(string $name);
}
