<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider;

use InvalidArgumentException;

/**
 * Class SettingsProvider
 * @package App\Infrastructure\Provider
 */
class SettingsProvider implements SettingsProviderInterface
{
    /**
     * @var array
     */
    private $settings;

    /**
     * SettingsProvider constructor.
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @inheritDoc
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @inheritDoc
     */
    public function getSettingByName(string $name)
    {
        if (empty($this->settings[$name])) {
            throw new InvalidArgumentException("Invalid setting name '$name'");
        }
        return $this->settings[$name];
    }
}
