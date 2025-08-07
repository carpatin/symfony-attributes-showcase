<?php

namespace App\Form;

use App\Entity\PhotoAlbum\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

class PhotoUploadForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'    => 'Photo title',
                'required' => true,
                'attr'     => ['class' => 'form-input'],
            ])
            ->add('description', TextareaType::class, [
                'label'    => 'Photo description',
                'required' => true,
                'attr'     => ['class' => 'form-textarea'],
            ])
            ->add('content', FileType::class, [
                'label'       => 'Photo file',
                'multiple'    => false,
                'mapped'      => false,
                'required'    => true,
                'attr'        => ['class' => 'form-input'],
                'constraints' => [
                    new Constraints\File(
                        maxSize: '15M',
                        mimeTypes: [
                            'image/jpeg',
                            'image/png',
                        ],
                        mimeTypesMessage: 'Please upload a valid JPEG or PNG image',
                    ),
                    new Constraints\Image(
                        maxWidth: 1920,
                        maxHeight: 1080,
                        maxWidthMessage: 'The image width is too large ({{ width }}px). Allowed maximum width is {{ max_width }}px.',
                        maxHeightMessage: 'The image height is too large ({{ height }}px). Allowed maximum height is {{ max_height }}px.',
                    ),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'        => Photo::class,
            'validation_groups' => ['form'],
            // customizing options for CSRF protection, just for example
            'csrf_protection'   => true, // default is true anyway
            'csrf_field_name'   => 'csrf', // instead of the default '_csrf_token'
            'csrf_token_id'     => 'single_upload', // replaces the default 'submit' - configured as stateless
        ]);
    }
}
