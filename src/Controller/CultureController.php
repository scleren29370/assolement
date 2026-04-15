<?php

namespace App\Controller;

use App\Entity\Culture;
use App\Form\CultureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CultureController extends AbstractController
{
    #[Route('/culture', name: 'culture_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $cultures = $em->getRepository(Culture::class)->findAll();

        return $this->render('culture/index.html.twig', [
            'cultures' => $cultures,
        ]);
    }

    #[Route('/culture/new', name: 'culture_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $culture = new Culture();
        $form = $this->createForm(CultureType::class, $culture);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($culture);
            $em->flush();

            return $this->redirectToRoute('culture_index');
        }

        return $this->render('culture/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
