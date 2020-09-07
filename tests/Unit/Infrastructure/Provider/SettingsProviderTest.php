<?php
declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Provider;

use App\Infrastructure\Provider\SettingsProvider;
use Tests\Unit\TestCase;


class SettingsProviderTest extends TestCase
{
    /**
     * @var SettingsProvider
     */
    private SettingsProvider $settingsProvider;

    public function setUp()
    {
        parent::setUp();

        $this->settingsProvider = $this->getDi()->get(SettingsProvider::class);
    }

    public function testGetSettingsByName(): void
    {
        $this->assertSame('matcha', $this->settingsProvider->getSettingByName('logger')['name']);
    }
}
