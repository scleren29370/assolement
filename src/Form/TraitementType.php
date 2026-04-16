<?php

namespace App\Form;

use App\Entity\Traitement;
use App\Reference\Referentiel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TraitementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'Type de traitement',
                'choices' => array_combine(
                    Referentiel::typesTraitement(),
                    Referentiel::typesTraitement()
                ),
                'placeholder' => 'Sélectionner un type',
            ])

            ->add('produit', TextType::class, [
                'label' => 'Produit',
            ])

            ->add('dose', TextType::class, [
                'label' => 'Dose',
            ])

            ->add('unite', ChoiceType::class, [
                'label' => 'Unité',
                'choices' => array_combine(
                    Referentiel::unitesDose(),
                    Referentiel::unitesDose()
                ),
                'placeholder' => 'Sélectionner une unité',
            ])

            ->add('dateTraitement', DateType::class, [
                'label' => 'Date du traitement',
                'widget' => 'single_text',
            ])

            ->add('commentaire', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
                'attr' => ['rows' => 4],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Traitement::class,
        ]);
    }
}
