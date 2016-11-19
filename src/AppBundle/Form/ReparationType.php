<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ReparationType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('customer', TextType::class, array('disabled' => true))
                ->add('state', EntityType::class, array(
                    'class' => 'AppBundle:RepairState',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('rs')
                                ->orderBy('rs.id', 'ASC');
                    },
                    'choice_label' => 'name',
                ))
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
                ->add('payment')
                ->add('entryDate', DateTimeType::class, array(
                                                                'widget' => 'single_text',
                                                                'format' => 'dd/MM/yyyy',
                                                                'required' => false,
                                                                'attr' => array('class' => 'datepicker',
                                                                    'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')))
                ->add('estimateDeliveryDate', DateTimeType::class, array(
                                                                        'widget' => 'single_text',
                                                                        'format' => 'dd/MM/yyyy',
                                                                        'required' => false,
                                                                        'attr' => array('class' => 'datepicker',
                                                                            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')))
                ->add('effectiveDeliveryDate', DateTimeType::class, array(
                                                                        'widget' => 'single_text',
                                                                        'format' => 'dd/MM/yyyy',
                                                                        'required' => false,
                                                                        'attr' => array('class' => 'datepicker',
                                                                            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')))
                ->add('observations')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Reparation'
        ));
    }

}
