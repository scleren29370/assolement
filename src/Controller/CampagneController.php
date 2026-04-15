<?php

namespace App\Controller;

use App\Entity\Campagne;
use App\Form\CampagneType;
use App\Repository\CampagneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/campagne')]
class CampagneController extends AbstractController
{
    #[Route('/', name: 'campagne_index')]
    public function index(CampagneRepository $repo): Response
    {
        return $this->render('campagne/index.html.twig', [
            'campagnes' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'campagne_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $campagne = new Campagne();
        $form = $this->createForm(CampagneType::class, $campagne);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($campagne);
            $em->flush();

            $this->addFlash('success', 'Campagne ajoutée avec succès');
            return $this->redirectToRoute('campagne_index');
        }

        return $this->render('campagne/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
