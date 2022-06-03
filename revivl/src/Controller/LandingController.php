<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Homework;
use App\Entity\Patient;
use App\Form\HomeworkType;
use App\Form\BuyType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LandingController
 * @package App\Controller
 *
*/
class LandingController extends AbstractController
{
    //todo прикрутить оплату
    #[Route('/{id}/buy', name: 'app_buy_course', methods: ["GET"])]
    public function getBuyCourse(Course $course, Request $request)
    {
        $patient = new Patient();
        $form = $this->createForm(BuyType::class, $patient);
        $form->handleRequest($request);

        return $this->render('landing/buy/buy.html.twig', [
            "course" => $course,
            'form' => $form->createView(),
        ]);
    }

    #[Route('', name: 'app_main', methods: "GET")]
    public function getMainPage(): Response
    {
        return $this->render('landing/main.html.twig', [
            'courses' => $this->entityManager->getRepository(Course::class)->getAll(),
        ]);
    }




}
