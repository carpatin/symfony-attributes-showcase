<?php

namespace App\Form;

use App\Entity\PhotoAlbum\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotoUploadForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'    => 'Photo Title',
                'required' => true,
                'attr'     => ['class' => 'form-input'],
            ])
            ->add('description', TextareaType::class, [
                'label'    => 'Description',
                'required' => true,
                'attr'     => ['class' => 'form-textarea'],
            ])
            ->add('content', FileType::class, [
                'label'    => 'Upload Image',
                'multiple' => false,
                'mapped'   => false,
                'required' => true,
                'attr'     => ['class' => 'form-input'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
