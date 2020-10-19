<?php


namespace App\Infrastructure\Mail;


use Swift_Message;


interface MailSenderInterface
{
    public function send(Swift_Message $message): int;
}
