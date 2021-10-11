<?php

namespace App\Controller\Stripe;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use App\MesServices\Stripe\CreerSessionService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    /**
     * @Route("/stripe/creer/session/{reference}", name="stripe_checkout")
     */
    public function createSession(CreerSessionService $creerSessionService, EntityManagerInterface $entityManager, $reference)
    {
        $order = $entityManager->getRepository(Order::class)->findByReference($reference);

        if(!$order)
        {
            $this->redirectToRoute('order');
        }

        $sessionStripe = $creerSessionService->create($order);
        return $this->redirect($sessionStripe->url);
    }
}