<?php 

namespace App\MesServices\Stripe;

use Stripe\Stripe;
use App\Classe\Cart;
use Stripe\Checkout\Session;
use Symfony\Component\Security\Core\Security;

class CreerSessionService 
{
    protected $keySecret;

    protected $panierService;

    protected $security;

    public function __construct($keySecret, Cart $cart ,Security $security)
    {
        $this->keySecret = $keySecret;
        $this->cart = $cart;
        $this->security = $security;
    }

    public function getDomain()
    {
        return 'https://localhost:8000';
    }

    public function getItems()
    {
        $produits_stripe = [];

        $products = $this->cart->getFull();

        foreach( $products as $item)
        {
            $produits_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item['product']->getPrice(),
                    'product_data' => [
                        'name' => $item['product']->getName()
                    ]
                ],
                'quantity' => $item['quantity']
            ];
        }

        return $produits_stripe;
    }

    public function create()
    {
        Stripe::setApiKey($this->keySecret);

        return Session::create([
            'customer_email' => $this->security->getUser()->getEmail(),
            'line_items' => [
                $this->getItems()
            ],
            'payment_method_types' => [
              'card',
            ],
            'mode' => 'payment',
            'success_url' => $this->getDomain() . '/success',
            'cancel_url' => $this->getDomain() . '/cancel',
          ]);
    }
}