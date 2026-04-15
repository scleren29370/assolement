<?php

namespace App\Controller;

use App\Entity\Parcelle;
use App\Form\ParcelleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParcelleController extends AbstractController
{
    #[Route('/parcelle/new', name: 'parcelle_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $parcelle = new Parcelle();
        $form = $this->createForm(ParcelleType::class, $parcelle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($parcelle);
            $em->flush();

            return $this->redirectToRoute('parcelle_new');
        }

        return $this->render('parcelle/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/parcelle', name: 'parcelle_index')]
public function index(EntityManagerInterface $em): Response
{
    $parcelles = $em->getRepository(Parcelle::class)->findAll();

    return $this->render('parcelle/index.html.twig', [
        'parcelles' => $parcelles,
    ]);
}

#[Route('/parcelle/edit/{id}', name: 'parcelle_edit')]
public function edit(Request $request, Parcelle $parcelle, EntityManagerInterface $em): Response
{
    $form = $this->createForm(ParcelleType::class, $parcelle);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        return $this->redirectToRoute('parcelle_index');
    }

    return $this->render('parcelle/edit.html.twig', [
        'form' => $form->createView(),
    ]);
}

}
