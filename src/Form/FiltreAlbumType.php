<?php

namespace App\Form;

use App\Entity\Style;
use App\Entity\Artiste;
use App\Model\FiltreAlbum;
use App\Repository\StyleRepository;
use App\Repository\ArtisteRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FiltreAlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr'=>[
                    'placeholder'=>"Saisir un partie du nom de l'album recherché"
                ],
                'required'=>false,
                'label'=>"Recherche sur le nom de l'album"
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
                'attr'=>[
                    'class'=>"selectStyles"
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'method'=>'get',
            'csrf_protection'=>false,
            'data_class'=> FiltreAlbum::class
        ]);
    }
}
