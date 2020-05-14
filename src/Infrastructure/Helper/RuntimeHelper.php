<?php


namespace App\Infrastructure\Helper;


use App\Infrastructure\Provider\SettingsProvider;

final class RuntimeHelper
{
    /**
     * @var SettingsProvider
     */
    private SettingsProvider $provider;

    public function __construct(SettingsProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param string $name Dir name
     * @return string Absolute dir path
     */
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