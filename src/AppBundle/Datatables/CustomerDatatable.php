<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class CustomerDatatable
 *
 * @package AppBundle\Datatables
 */
class CustomerDatatable extends AbstractDatatableView
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
                    'route' => $this->router->generate('customer_new'),
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
            'url' => $this->router->generate('customer_results'),
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
            'class' => Style::BOOTSTRAP_3_STYLE . ' table-condensed',
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'use_integration_options' => true,
            'force_dom' => false
        ));

        $this->columnBuilder
            ->add('id', 'column', array(
                'title' => '#',
                'width' => '40px',  
            ))
            ->add('createdAt', 'datetime', array(
                'visible'=> false,
                'title' => $this->translator->trans('Created at'),
            ))
            ->add('name', 'column', array(
                'title' => $this->translator->trans('Name'),
                'width' => '150px',  
            ))
            ->add('cuitDni', 'column', array(
                'title' => $this->translator->trans('Cuit dni'),
                'width' => '100px',  
            ))
            ->add('address', 'column', array(
                'visible'=> false,
                'title' => $this->translator->trans('Address'),
            ))
            ->add('city', 'column', array(
                'width' => '100px',  
                'title' => $this->translator->trans('City'),
            ))
            ->add('state', 'column', array(
                'visible'=> false,
                'title' => $this->translator->trans('State'),
            ))
            ->add('zipcode', 'column', array(
                'visible'=> false,
                'title' => $this->translator->trans('Zipcode'),
            ))
            ->add('phones', 'column', array(
                'title' => $this->translator->trans('Phones'),
                'width' => '120px',  
            ))
            ->add('email', 'column', array(
                'title' => $this->translator->trans('Email'),
                'width' => '150px',  
            ))
            ->add('observations', 'column', array(
                'visible'=> false,
                'title' => $this->translator->trans('Observations'),
            ))
            ->add('ivaCondition.name', 'column', array(
                'visible'=> false,
                'title' => $this->translator->trans('Iva condition'),
            ))
            ->add(null, 'action', array(
                'title' => $this->translator->trans('datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'customer_show',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('datatables.actions.show'),
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.show'),
                            'class' => 'btn btn-success btn-xs',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'customer_edit',
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
                    ),
                    array(
                        'route' => 'reparation_new',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('New reparation'),
                        'icon' => 'glyphicon glyphicon-plus',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('New reparation'),
                            'class' => 'btn btn-warning btn-xs',
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
        return 'AppBundle\Entity\Customer';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'customer_datatable';
    }
}
