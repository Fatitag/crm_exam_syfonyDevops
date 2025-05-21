<?php

namespace App\Form;

use App\Entity\Facture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
                'required' => true,
            ])
            ->add('montant', MoneyType::class, [
                'currency' => 'MAD',
                'label' => 'Amount',
                'required' => true,
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Paid' => 'Paid',
                    'Pending' => 'Pending',
                    'Canceled' => 'Canceled',
                ],
                'label' => 'Status',
                'required' => true,
                'placeholder' => 'Choose a status',
            ])

            ->add('note', TextareaType::class, [
                'label' => 'Note',
                'required' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
