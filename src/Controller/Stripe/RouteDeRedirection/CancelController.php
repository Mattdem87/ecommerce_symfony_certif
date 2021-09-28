<?php 

namespace App\Controller\Stripe\RouteDeRedirection;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CancelController extends AbstractController
{
    /**
     * @Route("/cancel", name="payment_cancel")
     */
    public function cancel()
    {
        dd("ca a pas marché. Tu as pas d'argent.");
    }
}