<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserEdit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class AccountEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFilename', FileType::class, [
                //'mapped' => false
                'required' => false,
                'constraints' => new Image([
                    'maxSize' => '300K',
                ])

            ])
            ->add('FirstName', TextType::class, [
                'label' => 'Имя',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserEdit::class,
        ]);
    }
}
