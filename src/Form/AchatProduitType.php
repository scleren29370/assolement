<?php

namespace App\Form;

use App\Entity\AchatProduit;
use App\Entity\Produit;
use App\Entity\Campagne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AchatProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nom',
                'label' => 'Produit',
                'placeholder' => 'Sélectionner un produit',
            ])
            ->add('prixUnitaire', NumberType::class, [
                'label' => 'Prix unitaire (€ / unité)',
                'scale' => 2,
                'required' => true,
            ])
            ->add('quantite', NumberType::class, [
                'label' => 'Quantité achetée',
                'scale' => 2,
                'required' => true,
            ])
            ->add('dateAchat', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d’achat',
                'required' => true,
            ])
            ->add('campagne', EntityType::class, [
                'class' => Campagne::class,
                'choice_label' => 'annee',
                'label' => 'Campagne',
                'placeholder' => 'Sélectionner une campagne',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AchatProduit::class,
        ]);
    }
}
