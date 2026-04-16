<?php

namespace App\EventSubscriber;

use App\Repository\CampagneRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class CampagneSubscriber implements EventSubscriberInterface
{
    private Environment $twig;
    private CampagneRepository $repo;

    public function __construct(Environment $twig, CampagneRepository $repo)
    {
        $this->twig = $twig;
        $this->repo = $repo;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $campagnes = $this->repo->findBy([], ['annee' => 'DESC']);

        // Injection dans TOUTES les vues Twig
        $this->twig->addGlobal('campagnes_dynamiques', $campagnes);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
