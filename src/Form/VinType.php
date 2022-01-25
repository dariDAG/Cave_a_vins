<?php

namespace App\Form;

use App\Entity\Vin;
use App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom du vin'])
            ->add('millesime', IntegerType::class, ['label' => 'Millésime'])
            ->add('robe', ChoiceType::class, [
                'label' => 'Type de vin',
                'choices' => [
                    'Vin rouge' => 'rouge',
                    'Vin blanc' => 'blanc',
                    'Vin rose' => 'rosé',
                ]
            ])
            ->add('qtt_stock', IntegerType::class, [
                'label' => 'Quantié en stock',
                'data' => 1
                ] )
            ->add('contenance', TextType::class, [
                'label' => 'Contenance  en mL'
                ])
            ->add('remarques', TextareaType::class, [
                'label' => 'Vos remarques',
                'required' => false
                ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'nom'
            ])

            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vin::class,
        ]);
    }
}
