<?php

namespace App\MessageHandler;

use App\Message\SmsNotification;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SmsNotificationHandler
{
    private $transport;
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }
    public function __invoke(SmsNotification $email)
    {
        $this->transport->send($email);
    }
}
