<?php

namespace App\Controller;

use App\Service\ValidateService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as AC;


abstract class AbstractController extends AC
{
    public function __construct(protected EntityManagerInterface $entityManager,
                                protected ValidateService $validator,
    )
    {
    }

}