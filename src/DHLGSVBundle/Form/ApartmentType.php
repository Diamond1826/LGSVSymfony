<?php

namespace DHLGSVBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ApartmentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('house', EntityType::class, array(
            'placeholder' => 'Wähle eine Liegenschaft',
            'class' => 'DHLGSVBundle:House',
            'choice_label' => 'street',
            'label' => 'Liegenschaft',
            'expanded' => false,
            'multiple' => false,

        ))->add('name', 'text',array(
            'label' => 'Bezeichnung',

        ))->add('rent', 'text',array(
            'label' => 'Miete',

        ))->add('Speichern', SubmitType::class, array(
    'attr' => array('class' => 'btn btn-default'),
    ));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DHLGSVBundle\Entity\Apartment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dhlgsvbundle_apartment';
    }


}
