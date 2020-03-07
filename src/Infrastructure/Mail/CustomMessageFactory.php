<?php


namespace App\Infrastructure\Mail;


use App\Infrastructure\Provider\SettingsProviderInterface;
use Swift_Message;

final class CustomMessageFactory
{
    /**
     * @var SettingsProviderInterface
     */
    private $settingsProvider;

    public function __construct(SettingsProviderInterface $settingsProvider)
    {
        $this->settingsProvider = $settingsProvider;
    }

    /**
     * @param string $subject
     * @return Swift_Message
     */
    public function create(string $subject): Swift_Message
    {
        $settings = $this->settingsProvider->getSettingByName('mail');

        return (new Swift_Message($subject))
            ->setFrom([$settings['MAIL_FROM_EMAIL'] => $settings['MAIL_FROM_FNAME']])
        ;
    }
}