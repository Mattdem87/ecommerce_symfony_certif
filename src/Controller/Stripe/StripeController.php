<?php

namespace App\Controller\Stripe;

use App\MesServices\Stripe\CreerSessionService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    /**
     * @Route("/stripe/creer/session", name="stripe_checkout")
     */
    public function createSession(CreerSessionService $creerSessionService)
    {
        $sessionStripe = $creerSessionService->create();

        return $this->redirect($sessionStripe->url);
    }
}