<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

/**
 * The form type for a blog post.
 */
class PostType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr' => [
                    'placeholder' => 'Title'
                ],
                'required' => true
            ])
            ->add('subtitle', TextType::class, [
                'label' => 'Subtitle',
                'attr' => [
                    'placeholder' => 'Subtitle'
                ],
                'required' => false
            ])
            ->add('publication_date', DateTimeType::class, [
                'label' => 'Publication date',
                'required' => true,
                'data' => new \DateTime('now')
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Post',
                'attr' => [
                    'placeholder' => 'Post content'
                ],
                'required' => true
            ])
            ->add('photo_filename', FileType::class, [
                'label' => 'Photo',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/*'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image.',
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults([
            'data_class' => Post::class
        ]);
    }
}
