<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class ReparationPaymentDatatable
 *
 * @package AppBundle\Datatables
 */
class ReparationPaymentDatatable extends AbstractDatatableView
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->topActions->set(array(
            'start_html' => '<div class="row"><div class="col-sm-3">',
            'end_html' => '<hr></div></div>',
            'actions' => array(
                array(
                    'route' => $this->router->generate('reparationpayment_new'),
                    'label' => $this->translator->trans('datatables.actions.new'),
                    'icon' => 'glyphicon glyphicon-plus',
                    'attributes' => array(
                        'rel' => 'tooltip',
                        'title' => $this->translator->trans('datatables.actions.new'),
                        'class' => 'btn btn-primary',
                        'role' => 'button'
                    ),
                )
            )
        ));

        $this->features->set(array(
            'auto_width' => true,
            'defer_render' => false,
            'info' => true,
            'jquery_ui' => false,
            'length_change' => true,
            'ordering' => true,
            'paging' => true,
            'processing' => true,
            'scroll_x' => false,
            'scroll_y' => '',
            'searching' => true,
            'state_save' => false,
            'delay' => 0,
            'extensions' => array()
        ));

        $this->ajax->set(array(
            'url' => $this->router->generate('reparationpayment_results'),
            'type' => 'GET'
        ));

        $this->options->set(array(
            'display_start' => 0,
            'defer_loading' => -1,
            'dom' => 'lfrtip',
            'length_menu' => array(10, 25, 50, 100),
            'order_classes' => true,
            'order' => array(array(0, 'asc')),
            'order_multi' => true,
            'page_length' => 10,
            'paging_type' => Style::FULL_NUMBERS_PAGINATION,
            'renderer' => '',
            'scroll_collapse' => false,
            'search_delay' => 0,
            'state_duration' => 7200,
            'stripe_classes' => array(),
            'class' => Style::BOOTSTRAP_3_STYLE,
            'individual_filtering' => false,
            'individual_filtering_position' => 'head',
            'use_integration_options' => true,
            'force_dom' => false
        ));

        $this->columnBuilder
            ->add('id', 'column', array(
                'title' => 'Id',
            ))
            ->add('date', 'datetime', array(
                'title' => 'Date',
            ))
            ->add('amount', 'column', array(
                'title' => 'Amount',
            ))
            ->add('concept', 'column', array(
                'title' => 'Concept',
            ))
            ->add('reparation.id', 'column', array(
                'title' => 'Reparation Id',
            ))
            ->add('reparation.brand', 'column', array(
                'title' => 'Reparation Brand',
            ))
            ->add('reparation.model', 'column', array(
                'title' => 'Reparation Model',
            ))
            ->add('reparation.series', 'column', array(
                'title' => 'Reparation Series',
            ))
            ->add('reparation.joystick', 'column', array(
                'title' => 'Reparation Joystick',
            ))
            ->add('reparation.battery', 'column', array(
                'title' => 'Reparation Battery',
            ))
            ->add('reparation.charger', 'column', array(
                'title' => 'Reparation Charger',
            ))
            ->add('reparation.diagnostic', 'column', array(
                'title' => 'Reparation Diagnostic',
            ))
            ->add('reparation.clientDescription', 'column', array(
                'title' => 'Reparation ClientDescription',
            ))
            ->add('reparation.technicalReport', 'column', array(
                'title' => 'Reparation TechnicalReport',
            ))
            ->add('reparation.budget', 'column', array(
                'title' => 'Reparation Budget',
            ))
            ->add('reparation.entryDate', 'column', array(
                'title' => 'Reparation EntryDate',
            ))
            ->add('reparation.estimateDeliveryDate', 'column', array(
                'title' => 'Reparation EstimateDeliveryDate',
            ))
            ->add('reparation.efectiveDeliveryDate', 'column', array(
                'title' => 'Reparation EfectiveDeliveryDate',
            ))
            ->add('reparation.observations', 'column', array(
                'title' => 'Reparation Observations',
            ))
            ->add(null, 'action', array(
                'title' => $this->translator->trans('datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'reparationpayment_show',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('datatables.actions.show'),
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.show'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'reparationpayment_edit',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('datatables.actions.edit'),
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.edit'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    )
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'AppBundle\Entity\ReparationPayment';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'reparationpayment_datatable';
    }
}
