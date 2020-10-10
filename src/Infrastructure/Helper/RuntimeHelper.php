<?php


namespace App\Infrastructure\Helper;


use App\Infrastructure\Provider\SettingsProvider;

final class RuntimeHelper
{
    private SettingsProvider $provider;

    public function __construct(SettingsProvider $provider)
    {
        $this->provider = $provider;
    }

    public function provideDir(string $name): string
    {
        $projectDir = $this->provider->getSettingByName('projectDir');
        $tokensDir = $projectDir . '/runtime/' . $name;

        if (!is_dir($tokensDir) && !mkdir($tokensDir, 0755, true) && !is_dir($tokensDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $tokensDir));
        }

        return $tokensDir;
    }
}
