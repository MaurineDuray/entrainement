<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceType extends ApplicationType
{

    

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'=> 'Titre',
                'attr'=> [
                    'placeholder'=> 'Titre de votre annonce'
                ]
            ])
            ->add('slug', TextType::class, $this->getConfiguration('Slug','Adresse web (automatique)',[
                'required'=>false
            ] ))
            ->add('price', MoneyType::class, $this->getConfiguration('Prix par nuit','Indiquer le prix que vous voulez pour une nuit') )
            ->add('introduction', TextType::class, $this->getConfiguration('Introduction', 'Donnez une description globale de votre annonce'))
            ->add('content', TextareaType::class, $this->getConfiguration('Description détaillée', "Donnez une description de votre bien"))
            ->add('coverImage', UrlType::class, $this->getConfiguration("L'url de l'image","Donnez l'adresse de votre image"))
            ->add('rooms', IntegerType::class, $this->getConfiguration('Prix par nuit','Indiquer le prix que vous voulez pour une nuit'))
            ->add(
                'images',
                CollectionType::class,[
                    'entry_type' =>ImageType::class,
                    'allow_add'=>true,
                    'allow_delete'=>true 
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
