<?php

namespace App\Controller;

use App\Entity\Assolement;
use App\Form\AssolementType;
use App\Repository\AssolementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/assolement')]
class AssolementController extends AbstractController
{
    #[Route('/', name: 'assolement_index')]
    public function index(AssolementRepository $repo): Response
    {
        return $this->render('assolement/index.html.twig', [
            'assolements' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'assolement_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $assolement = new Assolement();
        $form = $this->createForm(AssolementType::class, $assolement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($assolement);
            $em->flush();

            $this->addFlash('success', 'Assolement ajouté avec succès');
            return $this->redirectToRoute('assolement_index');
        }

        return $this->render('assolement/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function getCampagnes(AssolementRepository $repo): array
{
    return $repo->createQueryBuilder('a')
        ->select('DISTINCT a.campagne')
        ->orderBy('a.campagne', 'DESC')
        ->getQuery()
        ->getSingleColumnResult();
}

#[Route('/assolement/campagne/{id}', name: 'assolement_par_campagne')]
public function parCampagne(
    int $id,
    AssolementRepository $repo
): Response {
    $assolements = $repo->createQueryBuilder('a')
        ->join('a.campagne', 'c')
        ->where('c.id = :id')
        ->setParameter('id', $id)
        ->orderBy('a.dateSemis', 'ASC')
        ->getQuery()
        ->getResult();

    return $this->render('assolement/index.html.twig', [
        'assolements' => $assolements,
        'campagne_id' => $id,
    ]);
}
}

