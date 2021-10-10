<?php
declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Provider;

use App\Infrastructure\Provider\SettingsProvider;
use Tests\Unit\TestCase;


class SettingsProviderTest extends TestCase
{
    private SettingsProvider $settingsProvider;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->settingsProvider = $this->getDi()->get(SettingsProvider::class);
    }

    public function testGetSettingsByName(): void
    {
        $this->assertSame('matcha', $this->settingsProvider->getSettingByName('logger')['name']);
    }
}
