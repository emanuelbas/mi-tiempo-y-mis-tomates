<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\SecretQuestion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                    'group' => 'block1',
                    'data-parsley-errors-container' => '#email-input-errors',
                    'maxlength'=>'50',
                    'placeholder' => 'jorgelopez@gmail.com'
                ),
                'help' => 'Ejemplo: jorgelopez@gmail.com',
                'error_bubbling' => true,
            ))

            ->add('first_name', TextType::class, array(
                'label' => 'Nombre',
                'attr' => array(
                    'data-parsley-trigger' => "focusout",
                    'data-parsley-errors-container' => '#first-name-input-errors',
                    'data-parsley-required' => 'true',
                    'maxlength'=>'24',
                    'group' => 'block1',
                    'autofocus' => ''),
                'help' => 'Ejemplo: Jorge'))
            ->add('last_name', TextType::class, array(
                'label' => 'Apellido',
                'attr' => array(
                    'data-parsley-trigger' => "focusout",
                    'group' => 'block1',
                    'data-parsley-errors-container' => '#last-name-input-errors',
                    'data-parsley-required' => 'true',
                    'maxlength'=>'24',
                ),
                'help' => 'Ejemplo: Lopez'))
            ->add('secret_question', EntityType::class, array(
                'label' => 'Pregunta secreta',
                'class' => SecretQuestion::class,
                'attr' => array(
                    'data-parsley-trigger' => "focusout",
                    'group' => 'block1',
                )))
            ->add('secret_answer', TextType::class, array(
                'label' => 'Respuesta secreta',
                'attr' => array(
                    'data-parsley-trigger' => "focusout",
                    'group' => 'block1',
                    'data-parsley-errors-container' => '#secret-answer-input-errors',
                    'data-parsley-length' => '[2, 24]',
                    'maxlength'=>'24',
                ),
                'help' => 'Ejemplo: Buenos Aires'))

            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array(
                    'label' => 'Contraseña',
                    'help' => 'Entre 4 y 24 caracteres',
                    'attr' => array(
                        'data-parsley-trigger' => "focusout",
                        'group' => 'block1',
                        'data-parsley-errors-container' => '#first-password-input-errors',
                        'data-parsley-length' => '[4, 24]',
                        'maxlength'=>'24',
                    )),
                'second_options' => array(
                    'label' => 'Repita la contraseña',
                    'help' => 'Debe coincidir con la contraseña',
                    'attr' => array(
                        'data-parsley-trigger' => "focusout",
                        'group' => 'block1',
                        'data-parsley-errors-container' => '#second-password-input-errors',
                        'data-parsley-length' => '[4, 24]',
                        'maxlength'=>'24',
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