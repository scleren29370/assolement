<?php

namespace App\Form;

use App\Entity\Traitement;
use App\Entity\Produit;
use App\Reference\Referentiel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TraitementType extends AbstractType
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

            ->add('dose', NumberType::class, [
                'label' => 'Dose',
                'scale' => 2,
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
