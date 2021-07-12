<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'  => 'Name:',
                'help' => 'Make sure to add a valid name',
            ])
            ->add('surname', TextType::class, [
                'label'  => 'Surname:',
                'help' => 'Make sure to add a valid surname',
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Birth date:',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-datepicker'
                ],
            ])
            ->add('nie', TextType::class, [
                'label'  => 'NIE:',
                'help' => 'Make sure to add a valid nie',
            ])
            ->add('address', TextType::class, [
                'label'  => 'Address:',
            ])
            ->add('postalcode', IntegerType::class, [
                'label'  => 'Postal code:',
            ])
            ->add('town', TextType::class, [
                'label'  => 'Town:',
            ])
            ->add('city', TextType::class, [
                'label'  => 'City:',
            ])
            ->add('province', TextType::class, [
                'label'  => 'Province:',
            ])
            ->add('country', TextType::class, [
                'label'  => 'Country:',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
