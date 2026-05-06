<?php

namespace App\Form;

use App\Entity\Livraison;
use App\Entity\Assolement;
use App\Entity\Culture;
use App\Entity\Campagne;
use App\Repository\AssolementRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $annee = date('Y');

        $builder
            ->add('culture', EntityType::class, [
                'class' => Culture::class,
                'choice_label' => 'nom',
                'label' => 'Culture livrée',
            ])

            ->add('campagne', EntityType::class, [
                'class' => Campagne::class,
                'choice_label' => 'annee',
                'label' => 'Campagne',
                'query_builder' => fn($repo) =>
                    $repo->createQueryBuilder('c')
                        ->where('c.annee = :annee')
                        ->setParameter('annee', $annee),
            ])

            ->add('quantiteTotale', NumberType::class, [
                'label' => 'Quantité totale livrée (t)',
            ])

            ->add('dateLivraison', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de livraison',
                'data' => new \DateTime(),
            ])

            ->add('acheteur', TextType::class, [
                'required' => false,
                'label' => 'Acheteur / Coopérative',
            ])

            ->add('assolements', EntityType::class, [
                'class' => Assolement::class,
                'choice_label' => fn($a) => $a->getParcelle()->getNom() . ' (' . $a->getSurface() . ' ha)',
                'multiple' => true,
                'expanded' => true,
                'mapped' => false,
                'label' => 'Parcelles disponibles',
                'query_builder' => fn(AssolementRepository $repo) =>
                    $repo->createQueryBuilder('a')
                        ->join('a.campagne', 'c')
                        ->where('c.annee = :annee')
                     ->andWhere('a.id NOT IN (
    SELECT ass.id
    FROM App\Entity\Livraison l
    JOIN l.assolements ass
)')

                        ->setParameter('annee', $annee),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
