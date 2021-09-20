<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The form type for a user registration form.
 */
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('username', TextType::class, [
            'attr' => [
                'placeholder' => 'Please fill in your username'
            ],
            'required' => true
        ])
        ->add('password', PasswordType::class, [
            'attr' => [
                'placeholder' => 'Please fill in your password'
            ],
            'required' => true
        ])
        ->add('email', EmailType::class, [
            'attr' => [
                'placeholder' => 'Please fill in your email'
            ],
            'required' => true
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}