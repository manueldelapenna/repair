<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class ReparationDatatable
 *
 * @package AppBundle\Datatables
 */
class ReparationDatatable extends AbstractDatatableView
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
                    'route' => $this->router->generate('reparation_new'),
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
            'extensions' => array(
                                    'buttons' =>
                                        array(
                                                        'colvis',
                                                        'excel'=> array(
                                                                        'extend' => 'excel',
                                                                        'exportOptions' => array(
                                                                                        // show only the following columns:
                                                                                        'columns' => array(
                                                                                                        '1', 
                                                                                                        '2', 
                                            '3', 
                                            '4', 
                                            '5', 
                                            '6', 
                                                                                                                        )
                                                                                                        ),
                                                                                        ),
                                                        'pdf' => array(
                                                                        'extend' => 'pdf',
                                                                        'exportOptions' => array(
                                                                                        // show only the following columns:
                                                                                        'columns' => array(
                                                                                                        '1', 
                                                                                                        '2', 
                                            '3', 
                                            '4', 
                                            '5', 
                                            '6', 
                                                                                                                        )
                                                                                                        )
                                                                                        ),
                                        ),
                                    'responsive' => true
                                )
            
        ));

        $this->ajax->set(array(
            'url' => $this->router->generate('reparation_results'),
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
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'use_integration_options' => true,
            'force_dom' => false
        ));

        $this->columnBuilder
            ->add('id', 'column', array(
                'title' => 'Id',
                'width' => '40px',
            ))
            ->add('brand', 'column', array(
                'title' => $this->translator->trans('Brand'),
                'width' => '80px',
            ))
            ->add('model', 'column', array(
                'title' => $this->translator->trans('Model'),
                'width' => '80px',
            ))
            ->add('series', 'column', array(
                'title' => $this->translator->trans('Series'),
                'width' => '100px',
                'visible' => false,
            ))
                        
            ->add('entryDate', 'datetime', array(
                'title' => $this->translator->trans('Entry date'),
                'visible' => false,
            ))
            ->add('estimateDeliveryDate', 'datetime', array(
                'title' => $this->translator->trans('Estimate delivery date'),
                'visible' => false,
            ))
            ->add('effectiveDeliveryDate', 'datetime', array(
                'title' => $this->translator->trans('Effective delivery date'),
                'visible' => false,
            ))
            ->add('customer.name', 'column', array(
                'title' => $this->translator->trans('Customer Name'),
                'width' => '110px',
                
            ))
            ->add('customer.cuitDni', 'column', array(
                'title' => $this->translator->trans('Cuit dni'),
                'width' => '100px',
            ))
            
            ->add('customer.phones', 'column', array(
                'title' => $this->translator->trans('Phones'),
                'visible' => false,
            ))
            ->add('customer.email', 'column', array(
                'title' => $this->translator->trans('Email'),
                'visible' => false,
            ))
            ->add('state.name', 'column', array(
                'title' => $this->translator->trans('State'),
                'width' => '80px',
            ))
            ->add('budget', 'column', array(
                'title' => $this->translator->trans('Budg.'),
                'visible' => false,
            ))
            ->add('payment', 'column', array(
                'title' => $this->translator->trans('Payment'),
                'visible' => false,
            ))
            ->add(null, 'action', array(
                'title' => $this->translator->trans('datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'reparation_show',
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
                        'route' => 'reparation_edit',
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
        return 'AppBundle\Entity\Reparation';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'reparation_datatable';
    }
}
