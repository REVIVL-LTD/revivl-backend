<?php


namespace App\Controller\Lk;

use App\Controller\AbstractController;
use App\Entity\AbstractUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LkPanelController
 * @package App\Controller\Lk
 *
 * @Route("/lk")
 */
class LkPanelController extends AbstractController
{
    /**
     * @Route("", name="app_lk", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(): Response
    {
        /** @var AbstractUser $user */
        $user = $this->getUser();
        switch (true) {
            case $user->isAdmin():
                return $this->render(
                    'lk/admin/base_lk_admin.html.twig'
                );
            case $user->isDoctor():
                return $this->render(
                    'lk/doctor/base_lk_doctor.html.twig'
                );
            case $user->isPatient():
                return $this->render(
                    'lk/patient/base_lk_patient.html.twig'
                );
        }

        $this->addFlash('error', "Sorry, we can't open your account, please try again later.");
        return $this->redirectToRoute('app_main');
    }
}