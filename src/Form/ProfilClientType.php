<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Profil;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profil', ProfilType::class, [
                'data_class' => Profil::class,
                'label' => false
            ])
            ->add('user', UserType::class, [
                'data_class' => User::class,
                'label' => false,
                'disablePassword' => true,
                'disableTerms' => true
            ])
            ->add('client', ClientType::class, [
                'data_class' => Client::class,
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}