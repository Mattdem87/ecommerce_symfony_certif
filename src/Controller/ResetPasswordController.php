<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Entity\ResetPassword;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResetPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
       $this->entityManager = $entityManager; 
    }
    #[Route('/mot-de-passe-oublie', name: 'reset_password')]
    public function index(Request $request): Response
    {
        if ($this->getUser())
        {
            return $this->redirectToRoute('home');
        }

        if ($request->get('email'))
        {
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
            
            if ($user)
            {
                // Enregistrer en base la demande de reset_password
                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatedAt(new DateTime());
                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();

                // Envoyer un email à l'utilisateur avec un lien lui permettabt de mettre à jour son mdp

                $url = $this->generateUrl('update_password', [
                    'token' => $reset_password->getToken()
                ]);

                $content = "Bonjour ".$user->getFirstname()."<br/>Vous avez demandé à réinitialiser votre mot de passe sur le site ShoeShop.<br/><br/>";
                $content .= "Merci de bien vouloir cliquer sur le lien suivant pour <a href='".$url."'>mettre à jour votre mot de passe</a>.";

                $mail = new Mail();
                $mail->send($user->getEmail(), $user->getFirstname().' '.$user->getLastname(), 'Réinialiser votre mot de passe sur ShoeShop', $content);
            }
        }
        return $this->render('reset_password/index.html.twig');
    }

    #[Route('/modifier-mon-mot-de-passe/{token}', name: 'update_password')]
    public function update($token)
    {
        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);

        if (!$reset_password)
        {
            return $this->redirectToRoute('reset_password');
        }

        $now = new DateTime();
        if ($now > $reset_password->getCreatedAt()->modify('+ 1 hour'))
        {
            $this->addFlash('notice', 'Votre demande de mot de passe a expiré. Merci de renouveller votre demande.');
            return $this->redirectToRoute('reset_password');
        }

        dd($reset_password);
    }
}
