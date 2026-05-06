<?php

namespace App\Controller;

use App\Entity\AchatProduit;
use App\Form\AchatProduitType;
use App\Repository\AchatProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/achat-produit')]
class AchatProduitController extends AbstractController
{
    #[Route('/', name: 'achat_produit_index')]
    public function index(AchatProduitRepository $repo): Response
    {
        return $this->render('achat_produit/index.html.twig', [
            'achats' => $repo->findBy([], ['dateAchat' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'achat_produit_new')]
    public function new(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $achat = new AchatProduit();

        $form = $this->createForm(AchatProduitType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($achat);
            $em->flush();

            $this->addFlash('success', 'Achat enregistré avec succès.');

            return $this->redirectToRoute('achat_produit_index');
        }

        return $this->render('achat_produit/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'achat_produit_edit')]
    public function edit(
        AchatProduit $achat,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(AchatProduitType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            $this->addFlash('success', 'Achat modifié avec succès.');

            return $this->redirectToRoute('achat_produit_index');
        }

        return $this->render('achat_produit/edit.html.twig', [
            'form' => $form->createView(),
            'achat' => $achat,
        ]);
    }

    #[Route('/delete/{id}', name: 'achat_produit_delete')]
    public function delete(
        AchatProduit $achat,
        EntityManagerInterface $em
    ): Response {
        $em->remove($achat);
        $em->flush();

        $this->addFlash('success', 'Achat supprimé avec succès.');

        return $this->redirectToRoute('achat_produit_index');
    }
}
