<?php

namespace App\Controller\Stripe\RouteDeRedirection;

use App\Controller\OrderController;
use App\Classe\Cart;
use App\Entity\Order;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuccessController extends AbstractController
{
    /**
     * @Route("/success", name="payment_success")
     */
    public function success(Cart $cart)
    {
        //Je voudrais vider le panier
        $cart->viderPanier();

        //Je voudrais rediriger vers une page
        return $this->redirectToRoute('remerciement');
    }
}
