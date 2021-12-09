<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Topic;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('startAt', DateTimeType::class, array(
                'input' => 'datetime_immutable',
            ))
            ->add('endAt', DateTimeType::class, array(
                'input' => 'datetime_immutable',
            ))
            ->add('adress', TextareaType::class)
            ->add('topics', EntityType::class,['class'=>Topic::class,'multiple'=> true,'expanded'=> true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
