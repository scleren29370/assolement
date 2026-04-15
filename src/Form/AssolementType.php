<?php

namespace App\Form;

use App\Entity\Assolement;
use App\Entity\Campagne;
use App\Entity\Culture;
use App\Entity\Parcelle;
use App\Repository\ParcelleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssolementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('parcelle', EntityType::class, [
                'class' => Parcelle::class,
                'choice_label' => 'nom',
                'label' => 'Parcelle',
                'query_builder' => function (ParcelleRepository $repo) use ($options) {
                    $campagne = $options['campagne'];

                    return $repo->createQueryBuilder('p')
                        ->leftJoin('p.assolements', 'a')
                        ->leftJoin('a.campagne', 'c')
                        ->andWhere('c.id != :campagneId OR c.id IS NULL')
                        ->setParameter('campagneId', $campagne?->getId());
                },
            ])
            ->add('culture', EntityType::class, [
                'class' => Culture::class,
                'choice_label' => 'nom',
                'label' => 'Culture',
            ])
            ->add('dateSemis', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de semis',
            ])
            ->add('dateRecolte', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Date de récolte (optionnelle)',
            ])
            ->add('campagne', EntityType::class, [
                'class' => Campagne::class,
                'choice_label' => 'annee',
                'label' => 'Campagne',
                'placeholder' => 'Choisir une campagne',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assolement::class,
            'campagne' => null,   // 🔥 indispensable pour ton filtrage
        ]);
    }
}
