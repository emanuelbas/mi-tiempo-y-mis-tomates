<?php
namespace App\Form;

use App\Entity\PomodorosConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PomodoroConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('working_time', IntegerType::class, array(
                'label' => 'Tiempo de trabajo (minutos)',
                'attr' => array(
                    'data-parsley-trigger' => "focusout",
                    'data-parsley-errors-container' => '#working_time-input-errors',
                    'data-parsley-required' => 'true',
                    'maxlength'=>'24',
                    'group' => 'block1',
                    'autofocus' => ''),
                'help' => 'Ejemplo: 25'))
            ->add('break_time', IntegerType::class, array(
                'label' => 'Tiempo de descanso (minutos)',
                'attr' => array(
                    'data-parsley-trigger' => "focusout",
                    'data-parsley-errors-container' => '#break_time-input-errors',
                    'data-parsley-required' => 'true',
                    'maxlength'=>'24',
                    'group' => 'block1'),
                'help' => 'Ejemplo: 5'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PomodorosConfiguration::class,
        ));
    }
}