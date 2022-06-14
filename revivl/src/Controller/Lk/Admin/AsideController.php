<?php

namespace App\Controller\Lk\Admin;

use App\Controller\AbstractController;
use App\Entity\Course;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LkPanelController
 * @package App\Controller\Lk
 */
#[Route('/lk/admin')]
#[IsGranted('ROLE_ADMIN')]
class AsideController extends AbstractController
{

    #[Route('/sales', name: 'app_lk_admin_sales', methods: ["GET"])]
    public function sales(): Response
    {
        $sales = [];
        return $this->render(
            'lk/admin/sales/list.html.twig', [
                'sales' => $sales,
                'user' => $this->getUser(),
            ]
        );

    }

    #[Route('/users', name: 'app_lk_admin_users', methods: ["GET"])]
    public function users(): Response
    {
        $users = [];
        return $this->render(
            'lk/admin/users/list.html.twig', [
                'users' => $users,
                'user' => $this->getUser(),
            ]
        );

    }



    #[Route('/promos', name: 'app_lk_admin_promos', methods: ["GET"])]
    public function promos(): Response
    {
        $promos = [];
        return $this->render(
            'lk/admin/promos/list.html.twig', [
                'promos' => $promos,
                'user' => $this->getUser(),
            ]
        );

    }

    #[Route('/meals', name: 'app_lk_admin_meals', methods: ["GET"])]
    public function meals(): Response
    {
        $meals = [];
        return $this->render(
            'lk/admin/meals/list.html.twig', [
                'meals' => $meals,
                'user' => $this->getUser(),
            ]
        );

    }
}