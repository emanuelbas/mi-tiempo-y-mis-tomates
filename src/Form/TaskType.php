<?php
namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('task_name', TextType::class, array(
                'label' => 'Nombre',
                'attr' => array(
                    'data-parsley-trigger' => "focusout",
                    'data-parsley-errors-container' => '#task_name-input-errors',
                    'data-parsley-length' => '[2, 24]',
                    'maxlength'=>'24',
                    'group' => 'block1',
                    'autofocus' => ''),
                'help' => 'Ejemplo: Trabajo Practico'))
            ->add('stimated_pomodoros', IntegerType::class, array(
                'label' => 'Pomodoros estimados'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Task::class,
        ));
    }
}