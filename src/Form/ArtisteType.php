<?php

namespace App\Form;

use App\Entity\Artiste;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArtisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'label'=> "Nom de l'artiste",
                'attr'=>[
                    "placeholder"=>"saisir le nom de l'artiste"
                ]
            ])
            ->add('description', CKEditorType::class,[
                'config_name'=>'config_complete'
            ])
            ->add('site', UrlType::class)
            ->add('image', TextType::class, [
                'required'=>false
            ])
            ->add('type', ChoiceType::class, [
                "choices"=>[
                    "solo"=>0,
                    "groupe"=>1
                ]
            ])
            ->add('imageFile', FileType::class,[
                'block_prefix'=>'',
                'mapped'=>false,
                'required'=>false,
                'label'=>"charger la photo",
                'attr'=>[
                    'accept'=>".jpg,.png"
                ],
                'row_attr'=>[
                    'class'=>"d-none"
                ],
                'constraints' => [
                        new Image([
                            'maxSize' => '500k',
                            'maxSizeMessage'=>"la taille maximum doit être de 500ko",
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png'
                            ]
                        ])
                ]
            ])
            ->add('image', HiddenType::class)
            //->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artiste::class,
        ]);
    }
}
