<?php

namespace App\Form;


use App\Entity\Modele;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class VoitureForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('serie',TextType::class)
            ->add('DateMiseEnMarche',DateType::class)
            ->add('modele',TextType::class)
            ->add('PrixJour',NumberType::class)
            ->add('marque',EntityType::class,
                [
                    "class"=>Modele::class,
                    "choice_label"=>function($modele)
                    {
                        return $modele->getLibelle().'   '.$modele->getPays();},

                    "expanded"=>false,
                    "multiple"=>false
                ])
        ;
    }
    public function getName()
    {
        return "voiture";
    }
}