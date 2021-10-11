<?php

namespace App\Controller\Stripe\RouteDeRedirection;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use App\Controller\OrderController;
use Doctrine\ORM\EntityManagerInterface;
use App\MesServices\Stripe\CreerSessionService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuccessController extends AbstractController
{ 
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/success/{stripeSessionId}", name="payment_success")
     */
    public function success(Cart $cart, $stripeSessionId)
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$order || $order->getUser() != $this->getUser())
        {
            return $this->redirectToRoute('remerciement');
        }

        if(!$order->getIsPaid())
        {
            $order->setIsPaid(1);
            $this->entityManager->flush();

            $mail = new Mail;
            $content = 'Bonjour'.$order->getUser()->getFirstname().'<br/> merci pour votre commande';
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande est validé', $content);

        }
        //Je voudrais vider le panier
        $cart->viderPanier();

        return $this->render('remerciement.html.twig', [
            'order' => $order
        ]); 
        
    }
}
