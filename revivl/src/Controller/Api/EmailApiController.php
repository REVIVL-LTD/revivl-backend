<?php

namespace App\Controller\Api;

use App\Controller\AbstractController;
use App\Entity\Address;
use App\Entity\CodeAuth;
use App\Entity\Course;
use App\Entity\CourseUser;
use App\Entity\Order;
use App\Entity\Patient;
use App\Entity\Promo;
use App\Helper\DTO\BasketDTO;
use App\Helper\DTO\CodeAuthDto;
use App\Helper\DTO\EmailAuthDto;
use App\Helper\Status\OrderStatus;
use App\Helper\Status\UserStatus;
use App\Service\AutorizationService;
use App\Service\MailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailApiController extends AbstractController
{
    #[Route('/email/check', name: 'api_send_email_check', methods: "POST")]
    public function checkEmail(Request $request, AutorizationService $autorizationService): Response
    {
        $responseData = $this->validator->validRequest($request, EmailAuthDto::class, groupsBody: ["check"]);

        $autorizationService->checkEmail($responseData->body);

        return $this->json(data: null, status: Response::HTTP_OK);
    }

    //todo еще редирект на оплат  ????
    #[Route('/code/check', name: 'api_code_check', methods: "POST")]
    public function checkCodeEmail(Request $request, AutorizationService $autorizationService): Response
    {
        $responseData = $this->validator->validRequest($request, CodeAuthDto::class, groupsBody: ["check"]);

        $url = $autorizationService->chechCode($responseData->body->code, $responseData->body->email);

        return $this->json(data: ['url' => $url], status: Response::HTTP_OK);
    }
}