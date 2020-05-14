<?php


namespace App\Infrastructure\Mail;


use App\Infrastructure\Provider\SettingsProviderInterface;
use Swift_Message;

final class CustomMessageFactory
{
    /**
     * @var SettingsProviderInterface
     */
    private SettingsProviderInterface $settingsProvider;

    public function __construct(SettingsProviderInterface $settingsProvider)
    {
        $this->settingsProvider = $settingsProvider;
    }

    /**
     * Params:
     *   - subject
     *   - to
     *   - message body
     *
     * @param array $params
     * @return Swift_Message
     */
    public function create(array $params): Swift_Message
    {
        $settings = $this->settingsProvider->getSettingByName('mail');

        return (new Swift_Message($params['subject']))
            ->setFrom([$settings['from_email'] => $settings['from_fname']])
            ->setTo([$params['to'] => $params['to']])
            ->setBody($params['body'], 'text/html')
        ;
    }
}
