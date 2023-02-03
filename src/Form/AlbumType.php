<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Style;
use App\Entity\Artiste;
use App\Form\MorceauType;
use App\Repository\StyleRepository;
use App\Repository\ArtisteRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class,[
                'mapped'=>false,
                'required'=>false,
                'label'=>"charger la pochette",
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
            ->add('nom', TextType::class,[
                'label'=>"Nom de l'album",
                'required'=> false,
                'attr'=>[
                    'placeholder'=>"Saisir le nom de l'album"
                ]
            ])
            ->add('date', IntegerType::class,[
                'label'=>"Année de l'album",
                'required'=>false
            ])
            ->add('artiste', EntityType::class,[
                'class'=>Artiste::class,
                'query_builder'=>function(ArtisteRepository $repo){
                        return $repo->listeArtisteSimple();
                },
                'choice_label'=>'nom',
                'label'=>"Nom de l'artiste",
                'required'=>false
            ])
            ->add('styles',EntityType::class,[
                'class'=>Style::class,
                'query_builder'=>function(StyleRepository $repo){
                    return $repo->listeStylesSimple();
            },
                'choice_label'=>'nom',
                'label'=>"Style(s)",
                'required'=>false,
                'multiple'=>true,
                'by_reference'=>false,
                'attr'=>[
                    'class'=>"selectStyles"
                ]
            ])
            ->add("morceaux", CollectionType::class, [
                'entry_type'=> MorceauType::class,
                'label'=>false,
                'allow_add'=>true,
                'allow_delete'=>true,
                'prototype'=>true,
                'by_reference'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }

}
