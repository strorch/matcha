<?php


namespace App\Infrastructure\Helper;


use App\Infrastructure\Provider\SettingsProvider;
use Psr\Http\Message\UploadedFileInterface;

final class RuntimeHelper extends FileHelper
{
    private SettingsProvider $provider;

    public function __construct(SettingsProvider $provider)
    {
        $this->provider = $provider;
    }

    public function provideDir(string $name): string
    {
        $projectDir = $this->provider->getSettingByName('projectDir');
        $tokensDir = $projectDir . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR . $name;

        if (!is_dir($tokensDir) && !mkdir($tokensDir, 0755, true) && !is_dir($tokensDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $tokensDir));
        }

        return $tokensDir;
    }

    public function moveUploadedFile(UploadedFileInterface $uploadedFile)
    {
        $directory = $this->provideDir('photos');
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
