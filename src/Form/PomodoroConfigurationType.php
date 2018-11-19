<?php
namespace App\Form;

use App\Entity\PomodorosConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

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
                    'data-parsley-type' =>'digits',
                    'min' => '1',
                    'max' => '100',
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
                    'data-parsley-type' =>'digits',
                    'min' => '1',
                    'max' => '100',
                    'maxlength'=>'24',
                    'group' => 'block1'),
                'help' => 'Ejemplo: 5'))
            ->add('long_break_time', IntegerType::class, array(
                'label' => 'Tiempo de descanso largo (minutos)',
                'attr' => array(
                    'data-parsley-trigger' => "focusout",
                    'data-parsley-errors-container' => '#break_time-input-errors',
                    'data-parsley-required' => 'true',
                    'data-parsley-type' =>'digits',
                    'min' => '1',
                    'max' => '100',
                    'maxlength'=>'24',
                    'group' => 'block1'),
                'help' => 'Ejemplo: 30'))
            ->add('clock_sound', CheckboxType::class, array(
                'label'    => 'Activar sonido del reloj',
                'required' => false))
            ->add('end_work_alarm', CheckboxType::class, array(
                'label'    => 'Activar alarma de fin del periodo de trabajo',
                'required' => false))
            ->add('end_break_alarm', CheckboxType::class, array(
                'label'    => 'Activar alarma de fin del periodo de descanso',
                'required' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PomodorosConfiguration::class,
        ));
    }
}