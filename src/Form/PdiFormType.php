<?php

namespace App\Form;

use App\Entity\Pdi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PdiFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client_name', TextType::class, ['label' => 'Nom'])
            /*->add('numero')
            ->add('libelle_id', LibelleType::class, ['label' => 'Libellé'])*/
            ->add('is_depot', CheckboxType::class, ['label' => 'Cette adresse est un dépôt', 'required' => false])
            ->add('is_reex', CheckboxType::class, ['label' => 'Présence de contrat de réexpédition', 'required' => false])
            ->add('format')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pdi::class,
        ]);
    }
}
