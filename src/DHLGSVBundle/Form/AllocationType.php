<?php

namespace DHLGSVBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AllocationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('apartment', EntityType::class, array(
            'placeholder' => 'Wähle eine Wohnung',
            'class' => 'DHLGSVBundle:Apartment',
            'choice_label' => 'name',
            'label' => 'Wohnung',
            'expanded' => false,
            'multiple' => false,

        ))->add('tenant', EntityType::class, array(
            'placeholder' => 'Wähle einen Mieter',
            'class' => 'DHLGSVBundle:Tenant',
            'choice_label' => 'idlastnamefirstname',
            'label' => 'Mieter',
            'expanded' => false,
            'multiple' => false,

        ))->add('Speichern', SubmitType::class, array(
    'attr' => array('class' => 'btn btn-default'),));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DHLGSVBundle\Entity\Allocation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dhlgsvbundle_allocation';
    }


}
