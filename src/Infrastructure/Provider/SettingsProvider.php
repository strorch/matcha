<?php
declare(strict_types=1);

namespace App\Infrastructure\Provider;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;

/**
 * Class SettingsProvider
 * @package App\Infrastructure\Provider
 */
class SettingsProvider implements SettingsProviderInterface
{
    private array $settings;

    public function __construct(ContainerInterface $container)
    {
        $this->settings = $container->get('settings');
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
        return $this->settings[$name];
    }
}
