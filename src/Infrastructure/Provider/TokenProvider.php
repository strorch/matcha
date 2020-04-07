<?php


namespace App\Infrastructure\Provider;


use App\Domain\Entity\User;
use Symfony\Component\Serializer\SerializerInterface;

class TokenProvider implements TokenProviderInterface
{
    /**
     * @var SettingsProviderInterface
     */
    private $provider;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SettingsProviderInterface $provider, SerializerInterface $serializer)
    {
        $this->provider = $provider;
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function saveUser(User $user): string
    {
        $dir = $this->getTokensDir();
        $body = $this->serializer->serialize($user, 'json');
        $name = $this->generateTokenName(12);

        if (!(file_put_contents($dir . '/' . $name, $body))) {
            throw new \Exception('failed to save token');
        }

        return $name;
    }

    /**
     * @inheritDoc
     */
    public function find(string $hash): User
    {
        $tokensDir = $this->getTokensDir();
        $file = file_get_contents($tokensDir . '/' . $hash);

        return $this->serializer->deserialize($file, User::class, 'json');
    }

    /**
     * @inheritDoc
     */
    public function remove(string $hash): void
    {
        $tokensDir = $this->getTokensDir();
        unlink($tokensDir . '/' . $hash);
    }

    /**
     * @return string
     */
    private function getTokensDir(): string
    {
        $projectDir = $this->provider->getSettingByName('projectDir');
        $tokensDir = $projectDir . '/runtime/tokens';
        if (!is_dir($projectDir)) {
            @mkdir($tokensDir, 777, true);
        }

        return $tokensDir;
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateTokenName(int $length = 32): string
    {
        $res = '';
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $last = strlen($chars) - 1;
        for ($i = 0; $i < $length; ++$i) {
            $res .= $chars[mt_rand(0, $last)];
        }

        return $res;
    }
}
