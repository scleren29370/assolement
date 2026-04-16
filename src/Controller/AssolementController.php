<?php

namespace App\Controller;

use App\Entity\Assolement;
use App\Form\AssolementType;
use App\Repository\AssolementRepository;
use App\Repository\CampagneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rotation')]
class AssolementController extends AbstractController
{
    #[Route('/', name: 'assolement_index')]
    public function index(Request $request, AssolementRepository $repo, CampagneRepository $campRepo): Response
    {
        $idCampagne = $request->query->get('idCampagne');
        $campagne = $idCampagne ? $campRepo->find($idCampagne) : null;

        $assolements = $repo->findBy(['campagne' => $campagne]);

        return $this->render('assolement/index.html.twig', [
            'assolements' => $assolements,
            'campagne' => $campagne,
        ]);
    }

    #[Route('/new', name: 'assolement_new')]
    public function new(Request $request, EntityManagerInterface $em, CampagneRepository $campRepo): Response
    {
        $idCampagne = $request->query->get('idCampagne');
        $campagne = $campRepo->find($idCampagne);

        $assolement = new Assolement();
        $assolement->setCampagne($campagne);

        $form = $this->createForm(AssolementType::class, $assolement, [
            'campagne' => $campagne,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($assolement);
            $em->flush();

            return $this->redirectToRoute('assolement_index', [
                'idCampagne' => $campagne->getId(),
            ]);
        }

        return $this->render('assolement/new.html.twig', [
            'form' => $form->createView(),
            'campagne' => $campagne,
        ]);
    }

    #[Route('/campagne/{id}', name: 'assolement_par_campagne')]
    public function parCampagne(int $id, AssolementRepository $repo, CampagneRepository $campRepo): Response
    {
        $campagne = $campRepo->find($id);

       $assolements = $repo->findBy(['campagne' => $campagne]);

        return $this->render('assolement/index.html.twig', [
            'assolements' => $assolements,
            'campagne' => $campagne,
        ]);
    }
}
