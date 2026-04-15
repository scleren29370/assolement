<?php

namespace App\EventSubscriber;

use App\Repository\CampagneRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class CampagneSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private CampagneRepository $repo,
        private Environment $twig
    ) {}

    public function onKernelController(ControllerEvent $event)
    {
        $campagnes = $this->repo->createQueryBuilder('c')
            ->orderBy('c.annee', 'DESC')
            ->getQuery()
            ->getResult();

        $this->twig->addGlobal('campagnes_dynamiques', $campagnes);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
