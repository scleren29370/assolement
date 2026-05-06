<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Form\LivraisonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/livraison')]
class LivraisonController extends AbstractController
{
    #[Route('/', name: 'livraison_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $livraisons = $em->getRepository(Livraison::class)->findBy([], ['dateLivraison' => 'DESC']);

        return $this->render('livraison/index.html.twig', [
            'livraisons' => $livraisons,
        ]);
    }

    #[Route('/new', name: 'livraison_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $livraison = new Livraison();
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $assolements = $form->get('assolements')->getData();

            if (count($assolements) === 0) {
                $this->addFlash('danger', 'Vous devez sélectionner au moins une parcelle.');
                return $this->redirectToRoute('livraison_new');
            }

            // Convertir ArrayCollection → array
            $assolementsArray = $assolements->toArray();

            // Calcul surface totale
            $surfaceTotale = array_sum(array_map(
                fn($a) => $a->getSurface(),
                $assolementsArray
            ));

            if ($surfaceTotale <= 0) {
                $this->addFlash('danger', 'Surface totale invalide.');
                return $this->redirectToRoute('livraison_new');
            }

            // Répartition automatique
            foreach ($assolementsArray as $assolement) {

                $ratio = $assolement->getSurface() / $surfaceTotale;
                $quantite = $livraison->getQuantiteTotale() * $ratio;
                $rendement = $quantite / $assolement->getSurface();

                $assolement->setTonnage($quantite);
                $assolement->setRendement($rendement);

                $em->persist($assolement);
            }

            $em->persist($livraison);
            $em->flush();

            $this->addFlash('success', 'Livraison enregistrée et assolements mis à jour.');
            return $this->redirectToRoute('livraison_index');
        }

        return $this->render('livraison/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
