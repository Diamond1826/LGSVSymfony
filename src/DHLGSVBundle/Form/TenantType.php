<?php

namespace DHLGSVBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TenantType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', 'text',array(
            'label' => 'Vorname',

        ))->add('lastname', 'text',array(
            'label' => 'Nachname',

        ))->add('street', 'text',array(
            'label' => 'Strasse',

        ))->add('zipcode', 'integer',array(
            'label' => 'PLZ',

        ))->add('city', 'text',array(
            'label' => 'Ort',

        ))->add('email', 'email',array(
            'label' => 'E-Mail',

        ))->add('phone', 'text',array(
            'label' => 'Telefon',

        ))->add('Speichern', SubmitType::class, array(
    'attr' => array('class' => 'btn btn-default'),));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DHLGSVBundle\Entity\Tenant'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dhlgsvbundle_tenant';
    }


}
