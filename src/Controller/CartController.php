<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/panier', name: 'cart')]
    public function index(Cart $cart): Response
    {
        $cartComplet = [];

        if($cart->get())
        {
            foreach($cart->get() as $id => $quantity)
            {
                $cartComplet[] = [
                    'product' => $this->entityManager->getRepository(Product::class)->findOneById($id),
                    'quantity' => $quantity
                ];
            }
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cartComplet
        ]);
    }

   #[Route('/cart/add/{id}', name: 'add_cart')]
     public function add(Cart $cart, $id): Response
    {
        $cart->add($id);

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove', name: 'remove_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('cart');
    }

   #[Route('/cart/delete/{id}', name: 'delete_cart')]
   public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/decrease/{id}', name: 'decrease_cart')]
    public function decrease(Cart $cart, $id): Response
     {
         $cart->decrease($id);
 
         return $this->redirectToRoute('cart');
     }
}
