<?php
namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gerantNom', TextType::class, ['label' => "Manager's Last Name"])
            ->add('gerantPrenom', TextType::class, ['label' => "Manager's First Name"])
            ->add('raisonSociale', TextType::class, ['label' => 'Company Name'])
            ->add('telephone', TelType::class, ['label' => 'Phone Number'])
            ->add('adresse', TextType::class, ['label' => 'Postal Address'])
            ->add('ville', TextType::class, ['label' => 'City'])
            ->add('pays', TextType::class, ['label' => 'Country']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
