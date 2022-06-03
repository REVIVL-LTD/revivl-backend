<?php

namespace App\Service;

use App\Entity\CodeAuth;
use App\Entity\Patient;

class MailService extends AbstractEmailService
{
    public function checkEmail(Patient $patient): void
    {
        $code = new CodeAuth($patient);
        $this->entityManager->persist($code);
        $this->entityManager->flush();

        $context['code'] = $code->code;

        $this->sendTemplated($patient->getEmail(), 'Mail confirmation',
            'security/confirmation_email.html.twig', $context);
    }
}