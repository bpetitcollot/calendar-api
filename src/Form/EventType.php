<?php
namespace App\Form;

use App\Entity\Calendar;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
/**
 * Description of CalendarType
 *
 * @author bepetitcollot
 */
class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
                'label' => 'Titre de l\'événement',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Descriptif',
            ])
            ->add('date', TextType::class, [
                'label' => 'date',
            ])
            ->add('calendar', EntityType::class, [
                'label' => 'Calendrier',
                'class' => Calendar::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Event::class,
        ));
    }
    
    public function getBlockPrefix()
    {
        return 'event';
    }

}
