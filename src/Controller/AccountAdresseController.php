<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Adresse;
use App\Form\AdresseType;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAdresseController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/compte/adresses', name: 'account_adresse')]
    public function index(): Response
    {
        return $this->render('account/adresse.html.twig');
    }

    #[Route('/compte/ajouter_adresse', name: 'account_adresse_add')]
    public function add(Cart $cart,Request $request): Response
    {
        $adresse = new Adresse();

        $form = $this->createForm(AdresseType::class, $adresse);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $adresse->setUser($this->getUser());
            $this->entityManager->persist($adresse);
            $this->entityManager->flush();

            if($cart->get())
            {
                return $this->redirectToRoute('order');
            }
            else
            {
                return $this->redirectToRoute('account_adresse');
            }
        }

        return $this->render('account/adresse_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/compte/modifier_adresse/{id}', name: 'account_adresse_modifier')]
    public function edit(Request $request, $id): Response
    {
        $adresse = $this->entityManager->getRepository(Adresse::class)->findOneById($id);

        if(!$adresse || $adresse->getUser() != $this->getUser())
        {
            return $this->redirectToRoute('account_adresse');
        }

        $form = $this->createForm(AdresseType::class, $adresse);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $this->entityManager->flush();

            return $this->redirectToRoute('account_adresse');
        }

        return $this->render('account/adresse_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/compte/supprimer_adresse/{id}', name: 'account_adresse_supprimer')]
    public function delete($id): Response
    {
        $adresse = $this->entityManager->getRepository(Adresse::class)->findOneById($id);

        if($adresse && $adresse->getUser() == $this->getUser())
        {
            $this->entityManager->remove($adresse);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('account_adresse');
    }
}
