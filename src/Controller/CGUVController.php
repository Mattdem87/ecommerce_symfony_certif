<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CGUVController extends AbstractController
{
    #[Route('/cguv', name: 'cguv')]
    public function index(): Response
    {
        return $this->render('cguv/index.html.twig', [
            'controller_name' => 'CGUVController',
        ]);
    }
}
