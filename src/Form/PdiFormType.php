<?php

namespace App\Form;

use App\Entity\Pdi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PdiFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')
            ->add('client_name')
            ->add('is_depot')
            ->add('nb_boites')
            ->add('is_reex')/*
            ->add('createdAt')
            ->add('updatedAt')
            ->add('ordre')*/
            ->add('format')
            //->add('tournee_id')
            //->add('libelle_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pdi::class,
        ]);
    }
}
