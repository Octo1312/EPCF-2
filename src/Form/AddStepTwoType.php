<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\Color;
use App\Entity\Type;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddStepTwoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('effect')
            ->add('strength')
            ->add('imageName')
            ->add('updatedAt', null, [
                'widget' => 'single_text'
            ])
            ->add('name')
            ->add('toughness')
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'id',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('color', EntityType::class, [
                'class' => Color::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
