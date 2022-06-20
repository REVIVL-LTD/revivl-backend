<?php

namespace App\Controller\Lk\Admin;

use App\Entity\Promo;
use App\Form\PromoType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lk/admin/promo')]
#[IsGranted('ROLE_ADMIN')]
class PromoController extends AbstractController
{
    #[Route('', name: 'lk_admin_promo_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $promos = $entityManager
            ->getRepository(Promo::class)
            ->findAll();
        /** @var Promo $promo */
        foreach ($promos as $promo) {
            $n = $promo->getStatusName();
        }

        return $this->render('promo/index.html.twig', [
            'promos' => $promos,
        ]);
    }

    #[Route('/new', name: 'lk_admin_promo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $promo = new Promo();
        $form = $this->createForm(PromoType::class, $promo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($promo);
            $entityManager->flush();

            return $this->redirectToRoute('lk_admin_promo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promo/new.html.twig', [
            'promo' => $promo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'lk_admin_promo_show', methods: ['GET'])]
    public function show(Promo $promo): Response
    {
        return $this->render('promo/show.html.twig', [
            'promo' => $promo,
        ]);
    }

    #[Route('/{id}/edit', name: 'lk_admin_promo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Promo $promo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PromoType::class, $promo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('lk_admin_promo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promo/edit.html.twig', [
            'promo' => $promo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'lk_admin_promo_delete', methods: ['POST'])]
    public function delete(Request $request, Promo $promo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($promo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lk_admin_promo_index', [], Response::HTTP_SEE_OTHER);
    }
}
