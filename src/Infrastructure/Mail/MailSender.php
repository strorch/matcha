<?php


namespace App\Infrastructure\Mail;


use App\Infrastructure\Helper\RuntimeHelper;
use App\Infrastructure\Provider\SettingsProvider;
use DateTimeImmutable;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class MailSender implements MailSenderInterface
{
    private RuntimeHelper $runtimeHelper;

    private SettingsProvider $settingsProvider;

    private Swift_Mailer $swiftMailer;

    public function __construct(RuntimeHelper $runtimeHelper, SettingsProvider $settingsProvider)
    {
        $this->runtimeHelper = $runtimeHelper;
        $this->settingsProvider = $settingsProvider;
    }

    public function send(Swift_Message $message): int
    {
        $mailerEnabled = $this->settingsProvider->getSettingByName('mailerEnabled');

        return !$mailerEnabled ? $this->saveEmail($message) : $this->sendEmail($message);
    }

    public function getSwiftMailer(): Swift_Mailer
    {
        if (empty($this->swiftMailer)) {
            $this->swiftMailer = $this->buildSwiftMailer();
        }

        return $this->swiftMailer;
    }

    private function buildSwiftMailer()
    {
        $settings = $this->settingsProvider->getSettingByName('mail');

        $transport = (new Swift_SmtpTransport($settings['host'], $settings['port']))
            ->setUsername($settings['login'])
            ->setPassword($settings['password'])
            ->setEncryption('TLS')
        ;

        return new Swift_Mailer($transport);
    }

    private function sendEmail(Swift_Message $message): int
    {
        return $this->getSwiftMailer()->send($message);
    }

    private function saveEmail(Swift_Message $message): int
    {
        $mailDir = $this->runtimeHelper->provideDir('mail');
        $fileName = $this->generateMessageName();

        $filePath = $mailDir . '/' . $fileName;

        return !empty(file_put_contents($filePath, $message->toString()));
    }

    private function generateMessageName(): string
    {
        $date = (new DateTimeImmutable())
            ->format('Ymd-His');

        return $date . uniqid() . '.eml';
    }
}
