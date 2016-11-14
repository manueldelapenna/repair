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
            'extensions' => array()
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
            'individual_filtering' => false,
            'individual_filtering_position' => 'head',
            'use_integration_options' => true,
            'force_dom' => false
        ));

        $this->columnBuilder
            ->add('id', 'column', array(
                'title' => 'Id',
            ))
            ->add('brand', 'column', array(
                'title' => 'Brand',
            ))
            ->add('model', 'column', array(
                'title' => 'Model',
            ))
            ->add('series', 'column', array(
                'title' => 'Series',
            ))
            ->add('joystick', 'column', array(
                'title' => 'Joystick',
            ))
            ->add('battery', 'boolean', array(
                'title' => 'Battery',
            ))
            ->add('charger', 'boolean', array(
                'title' => 'Charger',
            ))
            ->add('diagnostic', 'column', array(
                'title' => 'Diagnostic',
            ))
            ->add('clientDescription', 'column', array(
                'title' => 'ClientDescription',
            ))
            ->add('technicalReport', 'column', array(
                'title' => 'TechnicalReport',
            ))
            ->add('budget', 'column', array(
                'title' => 'Budget',
            ))
            ->add('entryDate', 'datetime', array(
                'title' => 'EntryDate',
            ))
            ->add('estimateDeliveryDate', 'datetime', array(
                'title' => 'EstimateDeliveryDate',
            ))
            ->add('efectiveDeliveryDate', 'datetime', array(
                'title' => 'EfectiveDeliveryDate',
            ))
            ->add('observations', 'column', array(
                'title' => 'Observations',
            ))
            ->add('customer.id', 'column', array(
                'title' => 'Customer Id',
            ))
            ->add('customer.createdAt', 'column', array(
                'title' => 'Customer CreatedAt',
            ))
            ->add('customer.name', 'column', array(
                'title' => 'Customer Name',
            ))
            ->add('customer.cuitDni', 'column', array(
                'title' => 'Customer CuitDni',
            ))
            ->add('customer.address', 'column', array(
                'title' => 'Customer Address',
            ))
            ->add('customer.city', 'column', array(
                'title' => 'Customer City',
            ))
            ->add('customer.state', 'column', array(
                'title' => 'Customer State',
            ))
            ->add('customer.zipcode', 'column', array(
                'title' => 'Customer Zipcode',
            ))
            ->add('customer.phones', 'column', array(
                'title' => 'Customer Phones',
            ))
            ->add('customer.email', 'column', array(
                'title' => 'Customer Email',
            ))
            ->add('customer.observations', 'column', array(
                'title' => 'Customer Observations',
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
