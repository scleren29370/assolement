<?php

namespace App\Form;

use App\Entity\Produit;
use App\Reference\Referentiel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du produit',
            ])

            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => array_combine(
                    Referentiel::typesProduit(),
                    Referentiel::typesProduit()
                ),
                'placeholder' => 'Sélectionner un type',
            ])

            ->add('unite', ChoiceType::class, [
                'label' => 'Unité',
                'choices' => array_combine(
                    Referentiel::unitesDose(),
                    Referentiel::unitesDose()
                ),
                'placeholder' => 'Sélectionner une unité',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
