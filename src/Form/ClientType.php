<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'data-parsley-trigger' => "focusout",
                    'group' => 'block1'),
                'help' => 'Ejemplo: jorgelopez@gmail.com'))
            ->add('first_name', TextType::class, array(
                'label' => 'Nombre',
                'attr' => array(
                    'data-parsley-trigger' => "focusout",
                    'group' => 'block1',
                    'autofocus' => ''),
                'help' => 'Ejemplo: Jorge'))
            ->add('last_name', TextType::class, array(
                'label' => 'Apellido',
                'attr' => array(
                    'data-parsley-trigger' => "focusout",
                    'group' => 'block1'),
                'help' => 'Ejemplo: Lopez'))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array(
                    'label' => 'Contraseña',
                    'help' => 'Debe tener entre 4 y 24 caracteres',
                    'attr' => array(
                        'data-parsley-trigger' => "focusout",
                        'group' => 'block1',
                        'data-parsley-length' => '[4, 24]')),
                'second_options' => array(
                    'label' => 'Repita la contraseña',
                    'help' => 'Debe coincidir con la contraseña',
                    'attr' => array(
                        'data-parsley-trigger' => "focusout",
                        'group' => 'block1',
                        'data-parsley-length' => '[4, 24]',
                        'data-parsley-equalto' => "#client_password_first",
                        'data-parsley-equalto-message' => 'La contraseña debe concidir.')),
                'attr' => array(
                    'data-parsley-trigger' => "focusout",
                    'group' => 'block1')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Client::class,
        ));
    }
}