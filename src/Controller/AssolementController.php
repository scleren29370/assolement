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
    public function index(
        Request $request,
        AssolementRepository $repo,
        CampagneRepository $campRepo
    ): Response {
        $idCampagne = $request->query->get('idCampagne');
        $campagne = $idCampagne ? $campRepo->find($idCampagne) : null;

        $assolements = $campagne
            ? $repo->findByCampagne($idCampagne)
            : [];

        return $this->render('assolement/index.html.twig', [
            'assolements' => $assolements,
            'campagne' => $campagne,
        ]);
    }

    #[Route('/new', name: 'assolement_new')]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        CampagneRepository $campRepo
    ): Response {
        $idCampagne = $request->query->get('idCampagne');
        $campagne = $campRepo->find($idCampagne);

        $assolement = new Assolement();
        $assolement->setCampagne($campagne);

        $form = $this->createForm(AssolementType::class, $assolement, [
            'campagne' => $campagne,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $assolement->setSurface($assolement->getParcelle()->getSurface());

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
    public function parCampagne(
        int $id,
        AssolementRepository $repo,
        CampagneRepository $campRepo
    ): Response {
        $campagne = $campRepo->find($id);

        $assolements = $repo->findByCampagne($id);

        return $this->render('assolement/index.html.twig', [
            'assolements' => $assolements,
            'campagne' => $campagne,
        ]);
    }

    #[Route('/stats/{idCampagne}', name: 'assolement_stats')]
    public function stats(
        int $idCampagne,
        AssolementRepository $repo,
        CampagneRepository $campRepo
    ): Response {
        $campagne = $campRepo->find($idCampagne);

        $data = $repo->sumSurfaceByCulture($idCampagne);

        $labels = array_column($data, 'culture');
        $values = array_column($data, 'total');

        $totalSurface = array_sum($values);

        $percentages = [];
        foreach ($data as $row) {
            $percentages[$row['culture']] = $totalSurface > 0
                ? round(($row['total'] / $totalSurface) * 100, 1)
                : 0;
        }

        return $this->render('assolement/stats.html.twig', [
            'campagne' => $campagne,
            'labels' => json_encode($labels),
            'values' => json_encode($values),
            'data' => $data,
            'percentages' => $percentages,
            'totalSurface' => $totalSurface,
        ]);
    }
}
