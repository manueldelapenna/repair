<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ReparationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer')
            ->add('brand')
            ->add('model')
            ->add('series')
            ->add('joystick')
            ->add('battery')
            ->add('charger')
            ->add('diagnostic')
            ->add('clientDescription')
            ->add('technicalReport')
            ->add('budget')
            ->add('entryDate', DateTimeType::class)
            ->add('estimateDeliveryDate', DateTimeType::class)
            ->add('efectiveDeliveryDate', DateTimeType::class)
            ->add('observations')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Reparation'
        ));
    }
}
