<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Style;
use App\Entity\Artiste;
use App\Repository\StyleRepository;
use App\Repository\ArtisteRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image')
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
                'multiple'=>true
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
