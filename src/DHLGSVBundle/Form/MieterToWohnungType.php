<?php

namespace DHLGSVBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MieterToWohnungType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('wohnung', EntityType::class, array(
            'class' => 'DHLGSVBundle:Wohnung',
            'choice_label' => 'name',
            'label' => 'Wohnung',
            'expanded' => false,
            'multiple' => false,

        ))->add('mieter', EntityType::class, array(
            'class' => 'DHLGSVBundle:Mieter',
            'choice_label' => 'idnachnamevorname',
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
            'data_class' => 'DHLGSVBundle\Entity\MieterToWohnung'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dhlgsvbundle_mietertowohnung';
    }


}
