<?php

namespace DHLGSVBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class WohnungType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('house', EntityType::class, array(
            'class' => 'DHLGSVBundle:House',
            'choice_label' => 'strasse',
            'expanded' => false,
            'multiple' => false,

        ))->add('name')->add('miete')->add('Speichern', SubmitType::class, array(
    'attr' => array('class' => 'btn btn-default'),
    ));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DHLGSVBundle\Entity\Wohnung'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dhlgsvbundle_wohnung';
    }


}
