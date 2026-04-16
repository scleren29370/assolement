<?php

namespace App\Controller;

use App\Entity\Traitement;
use App\Entity\Assolement;
use App\Form\TraitementType;
use App\Repository\AssolementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TraitementController extends AbstractController
{
    #[Route('/traitement/new/{idAssolement}', name: 'traitement_new')]
    public function new(
        int $idAssolement,
        Request $request,
        EntityManagerInterface $em,
        AssolementRepository $assoRepo
    ): Response {
        $assolement = $assoRepo->find($idAssolement);

        if (!$assolement) {
            throw $this->createNotFoundException("Assolement introuvable.");
        }

        $traitement = new Traitement();
        $traitement->setAssolement($assolement);

        $form = $this->createForm(TraitementType::class, $traitement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($traitement);
            $em->flush();

            return $this->redirectToRoute('assolement_par_campagne', [
                'id' => $assolement->getCampagne()->getId(),
            ]);
        }

        return $this->render('traitement/new.html.twig', [
            'form' => $form->createView(),
            'assolement' => $assolement,
        ]);
    }

    #[Route('/traitement/{id}/edit', name: 'traitement_edit')]
public function edit(
    Traitement $traitement,
    Request $request,
    EntityManagerInterface $em
): Response {
    $form = $this->createForm(TraitementType::class, $traitement);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();

        return $this->redirectToRoute('assolement_par_campagne', [
            'id' => $traitement->getAssolement()->getCampagne()->getId(),
        ]);
    }

    return $this->render('traitement/edit.html.twig', [
        'form' => $form->createView(),
        'traitement' => $traitement,
    ]);
}

}
