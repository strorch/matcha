<?php


namespace App\Infrastructure\Mail;


use Swift_Message;


interface MailerInterface
{
    public function send(Swift_Message $message): void;
}