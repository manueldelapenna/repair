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
    public function getLineFormatter()
    {
        $formatter = function($line){
            $em = $this->getEntityManager();       
            $reparation = $em->find('AppBundle\Entity\Reparation', $line['id']);
           
            switch ($reparation->getRepairTimeState()) {
                case \AppBundle\Entity\Reparation::SIN_FECHA_PACTADA:
                    $line['repairTimeState'] = '<span class="label label-warning">Sin fecha pactada</span>';
                    break;
                    
                case \AppBundle\Entity\Reparation::TRABAJO_TERMINADO_ANULADO:
                    $line['repairTimeState'] = '<span class="label label-success">Trabajo terminado</span>';
                    break;
                
                case \AppBundle\Entity\Reparation::TRABAJO_RETRASADO:
                    $line['repairTimeState'] = '<span class="label label-danger">Trabajo retrasado</span>';
                    break;
                    
                case \AppBundle\Entity\Reparation::DENTRO_TIEMPO_PACTADO:
                    $line['repairTimeState'] = '<span class="label label-info">Dentro del tiempo pactado</span>' ;
                    break;
                    
                case \AppBundle\Entity\Reparation::CERCA_FECHA_ENTREGA:
                    $line['repairTimeState'] = '<span class="label label-warning">Cerca de fecha de entrega</span>';
                    break;
                    
            }
            
            $line['due'] = $line['budget'] - $line['payment'];
            
            return $line;

        };

        return $formatter;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->topActions->set(array(
            'start_html' => '<div class="row"><div class="col-sm-3">',
            'end_html' => '<hr></div></div>',
            'actions' => array(
//                array(
//                    'route' => $this->router->generate('reparation_new'),
//                    'label' => $this->translator->trans('datatables.actions.new'),
//                    'icon' => 'glyphicon glyphicon-plus',
//                    'attributes' => array(
//                        'rel' => 'tooltip',
//                        'title' => $this->translator->trans('datatables.actions.new'),
//                        'class' => 'btn btn-primary',
//                        'role' => 'button'
//                    ),
//                )
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
                                'buttons' =>array(
                                                    //'colvis',
                                                    'excel'=> array(
                                                                    'extend' => 'excel',
                                                                    'text' => 'Exportar Excel',
                                                                    'exportOptions' => array(
                                                                                            // show only the following columns:
                                                                                            'columns' => array(
                                                                                                                '0',
                                                                                                                '1', 
                                                                                                                '2', 
                                                                                                                '3', 
                                                                                                                '4', 
                                                                                                                '5', 
                                                                                                                '6',
                                                                                                                '7',
                                                                                                                '8',
                                                                                                                '9',
                                                                                                                '10',
                                                                                                                '11',
                                                                                                                '12',
                                                                                                                '13',
                                                                                                                '14',
                                                                                                                '15',
                                                                                                                '16', 
                                                                                                               )
                                                                                            ),
                                                                    ),
                                                ),
                                'responsive' => true
                                )
        ));

        
        
    switch ($options['results']) {
        case 'delayed':
            $this->ajax->set(array(
                'url' => $this->router->generate('reparation_delayed_results'),
                'type' => 'GET'
            ));
            break;
        case 'ok':
            $this->ajax->set(array(
                'url' => $this->router->generate('reparation_ok_results'),
                'type' => 'GET'
            ));
            break;
        case 'warning':
            $this->ajax->set(array(
                'url' => $this->router->generate('reparation_warning_results'),
                'type' => 'GET'
            ));
            break;
        case 'without_date':
            $this->ajax->set(array(
                'url' => $this->router->generate('reparation_without_date_results'),
                'type' => 'GET'
            ));
            break;
        case 'finished':
            $this->ajax->set(array(
                'url' => $this->router->generate('reparation_finished_results'),
                'type' => 'GET'
            ));
            break;
        default:
            $this->ajax->set(array(
                'url' => $this->router->generate('reparation_results'),
                'type' => 'GET'
             ));
    }


        $this->options->set(array(
            'display_start' => 0,
            'defer_loading' => -1,
            'dom' => 'lfrtip',
            'length_menu' => array(50, 100, 200, -1),
            'order_classes' => true,
            'order' => array(array(0, 'asc')),
            'order_multi' => true,
            'page_length' => 50,
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

        $states = $this->em->getRepository('AppBundle:RepairState')->findAll();
        
        $this->columnBuilder
            ->add('id', 'column', array(
                'title' => '#',
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
                //'visible' => false,
                'date_format' => 'DD/MM/Y',
                'width' => '80px',
                'filter' => array('daterange', array())
            ))
            ->add('estimateDeliveryDate', 'datetime', array(
                'title' => $this->translator->trans('Estimate delivery date'),
                'visible' => false,
                'date_format' => 'DD/MM/Y',
                'width' => '80px',
                'filter' => array('daterange', array())
            ))
            ->add('effectiveDeliveryDate', 'datetime', array(
                'title' => $this->translator->trans('Effective delivery date'),
                'visible' => false,
            ))
                
            ->add('customer.id', 'column', array(
                'title' => $this->translator->trans('Customer Number'),
                'visible' => false,
                
            ))
            ->add('customer.name', 'column', array(
                'title' => $this->translator->trans('Customer Name'),
                'width' => '110px',
                
            ))
            ->add('customer.cuitDni', 'column', array(
                'title' => $this->translator->trans('Cuit dni'),
                'width' => '80px',
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
                'width' => '160px',
                'filter' => array('select', array(
                    'search_type' => 'eq',
                    'select_options' => array('' => 'Todos') + $this->getCollectionAsOptionsArray($states, 'name', 'name'),
                )),
            ))
            ->add('repairTimeState', 'virtual', array(
                'title' => $this->translator->trans('Repair time state'),
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
            
            ->add('due', 'virtual', array(
                'title' => $this->translator->trans('Due'),
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
                            'class' => 'btn btn-success btn-xs',
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
                    ),
                    array(
                        'route' => 'reparation_export',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('Print'),
                        'icon' => 'glyphicon glyphicon-print',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('Export'),
                            'class' => 'btn btn-info btn-xs',
                            'role' => 'button'
                        )
                    ),
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
