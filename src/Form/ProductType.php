<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\SousCategorieProduit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle',
                TextType::class,
                $this->getConfiguration("Libellé :", "Libellé du produit...")
            )
            ->add('description',
                TextareaType::class,
                $this->getConfiguration("Description : ", "Description du produit...")
            )
            ->add("prix",
                MoneyType::class,
                $this->getConfiguration("Prix : ", "Prix du produit...")
            )
            ->add('image',
                UrlType::class,
                $this->getConfiguration("Image : ", "Liens vers l'image")
            )
            ->add('SousCategorieProduit',
                EntityType::class, [
                    'class' => SousCategorieProduit::class,
                    'choice_label' => "libelle"
                ]
            )
            ->add('parfume',
                ChoiceType::class,
                [
                    'label' => "Parfum :",
                    'choices' => [
                        'Nature' => false,
                        'Parfumé' => true,
                        'Ce produit ne concerne pas les parfums' => null //A gérer en ajax dans le futur en se basant sur la propriété "hasParfume" de la sous-catégorie, pas les compétences requises au moment fait.
                    ],

                    'empty_data' => null
                ]
            )
            ->add('origine',
                TextType::class,
                $this->getConfiguration("Origine :", "Origine du produit")
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
