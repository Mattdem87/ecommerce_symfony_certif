<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash('notice', 'Merci de nous avoir contacté. Nos équipes vous répondra dans le smeilleurs délais.');

            $content = "Bonjour " . $user->getFirstname() . "<br/>Vous avez reçu un message d'un utilisateur de la boutique ShoeShop.<br/><br/>";
            $mail = new Mail();
            $mail->send('dembele-matala@live.fr','ShoeShop', 'Vous avez reçu une nouvelle demande de contact', $content);
        }
        return $this->render('contact/index.html.twig');
    }
}
