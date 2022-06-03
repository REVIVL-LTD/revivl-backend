<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

abstract class AbstractEmailService
{
    public function __construct(private readonly MailerInterface $mailer, protected EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param string $mailTo
     * @param string $subject
     * @param string $text
     */
    public function sendText(string $mailTo, string $subject, string $text): void
    {
        $email = (new Email())
            ->to($mailTo)
            ->subject($subject)
            ->text($text);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
//todo закинуть в очередь
        }
    }

    /**
     * @param string $mailTo
     * @param string $subject
     * @param string $template
     * @param array $context
     */
    public function sendTemplated(string $mailTo, string $subject, string $template, array $context = []): void
    {
        $email = (new TemplatedEmail())
            ->to($mailTo)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($context);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
//todo закинуть в очередь
        }
    }
}