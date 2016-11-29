<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Reparation;
use AppBundle\Entity\Customer;
use AppBundle\Entity\RepairState;
use AppBundle\Form\ReparationType;
use Zend_Pdf;
use Zend_Pdf_Font;

/**
 * Reparation controller.
 *
 * @Route("/admin/reparation")
 */
class ReparationController extends Controller
{
    /**
     * Lists all Reparation entities.
     *
     * @Route("/", name="reparation_index")
     * @Method("GET")
     */
    public function indexAction() {
        $datatable = $this->get('app.datatable.reparation');
        $datatable->buildDatatable(array('results' => 'all'));

        return $this->render('reparation/index.html.twig', array(
                    'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="reparation_results")
     */
    public function indexResultsAction() {
        $datatable = $this->get('app.datatable.reparation');
        $datatable->buildDatatable(array('results' => 'all'));

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }
    
    /**
     * Lists delayed Reparation entities.
     *
     * @Route("/delayed", name="reparation_delayed")
     * @Method("GET")
     */
    public function delayedAction() {
        $datatable = $this->get('app.datatable.reparation');
        $datatable->buildDatatable(array('results' => 'delayed'));

        return $this->render('reparation/delayed.html.twig', array(
                    'datatable' => $datatable,
                    'timeState' => 'delayed',
        ));
    }

    /**
     * @Route("/delayed_results", name="reparation_delayed_results")
     */
    public function delayedResultsAction() {
        $datatable = $this->get('app.datatable.reparation');
        $datatable->buildDatatable(array('results' => 'delayed'));
        
        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        $function = function($qb)
        {
            $now = new \DateTime("now");
            
            $qb->andWhere("state.id <> :st1");
            $qb->setParameter('st1', RepairState::ENTREGADO);
            $qb->andWhere("state.id <> :st2");
            $qb->setParameter('st2', RepairState::RECHAZADO_ANULADO);
            $qb->andWhere("state.id <> :st3");
            $qb->setParameter('st3', RepairState::REPARADO_RETIRAR);
            $qb->andWhere("reparation.estimateDeliveryDate is not null");
            $qb->andWhere("reparation.estimateDeliveryDate < :day");
            $qb->setParameter('day', $now);
        };

        $query->addWhereAll($function);

        return $query->getResponse();
       
    }
    
    /**
     * Lists on time Reparation entities.
     *
     * @Route("/on_time", name="reparation_ok")
     * @Method("GET")
     */
    public function onTimeAction() {
        $datatable = $this->get('app.datatable.reparation');
        $datatable->buildDatatable(array('results' => 'ok'));

        return $this->render('reparation/on_time.html.twig', array(
                    'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/ok_results", name="reparation_ok_results")
     */
    public function onTimeResultsAction() {
        $datatable = $this->get('app.datatable.reparation');
        $datatable->buildDatatable(array('results' => 'ok'));
        
        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        $function = function($qb)
        {
            $now = new \DateTime("now");
            
            $qb->andWhere("state.id <> :st1");
            $qb->setParameter('st1', RepairState::ENTREGADO);
            $qb->andWhere("state.id <> :st2");
            $qb->setParameter('st2', RepairState::RECHAZADO_ANULADO);
            $qb->andWhere("state.id <> :st3");
            $qb->setParameter('st3', RepairState::REPARADO_RETIRAR);
            $qb->andWhere("reparation.estimateDeliveryDate is not null");
            $qb->andWhere("DATE_SUB(reparation.estimateDeliveryDate, 2, 'day') > :day");
            $qb->setParameter('day', $now);
            
        };

        $query->addWhereAll($function);

        return $query->getResponse();
       
    }
    
    /**
     * Lists warning Reparation entities.
     *
     * @Route("/warning", name="reparation_warning")
     * @Method("GET")
     */
    public function warningAction() {
        $datatable = $this->get('app.datatable.reparation');
        $datatable->buildDatatable(array('results' => 'warning'));

        return $this->render('reparation/warning.html.twig', array(
                    'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/warning_results", name="reparation_warning_results")
     */
    public function warningResultsAction() {
        $datatable = $this->get('app.datatable.reparation');
        $datatable->buildDatatable(array('results' => 'warning'));
        
        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        $function = function($qb)
        {
            $now = new \DateTime("now");
            
            $qb->andWhere("state.id <> :st1");
            $qb->setParameter('st1', RepairState::ENTREGADO);
            $qb->andWhere("state.id <> :st2");
            $qb->setParameter('st2', RepairState::RECHAZADO_ANULADO);
            $qb->andWhere("state.id <> :st3");
            $qb->setParameter('st3', RepairState::REPARADO_RETIRAR);
            $qb->andWhere("reparation.estimateDeliveryDate is not null");
            $qb->andWhere("reparation.estimateDeliveryDate >= :day1");
            $qb->setParameter('day1', $now);
            $qb->andWhere("DATE_SUB(reparation.estimateDeliveryDate, 2, 'day') <= :day2");
            $qb->setParameter('day2', $now);
            
            
        };

        $query->addWhereAll($function);

        return $query->getResponse();
       
    }
    
    /**
     * Lists without date Reparation entities.
     *
     * @Route("/without_date", name="reparation_without_date")
     * @Method("GET")
     */
    public function withoutDateAction() {
        $datatable = $this->get('app.datatable.reparation');
        $datatable->buildDatatable(array('results' => 'without_date'));

        return $this->render('reparation/without_date.html.twig', array(
                    'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/without_date_results", name="reparation_without_date_results")
     */
    public function withoutDateResultsAction() {
        $datatable = $this->get('app.datatable.reparation');
        $datatable->buildDatatable(array('results' => 'without_date'));
        
        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        $function = function($qb)
        {
            
            $qb->andWhere("state.id <> :st1");
            $qb->setParameter('st1', RepairState::ENTREGADO);
            $qb->andWhere("state.id <> :st2");
            $qb->setParameter('st2', RepairState::RECHAZADO_ANULADO);
            $qb->andWhere("state.id <> :st3");
            $qb->setParameter('st3', RepairState::REPARADO_RETIRAR);
            $qb->andWhere("reparation.estimateDeliveryDate is null");
            
        };

        $query->addWhereAll($function);

        return $query->getResponse();
       
    }
    
    /**
     * Lists finished Reparation entities.
     *
     * @Route("/finished", name="reparation_finished")
     * @Method("GET")
     */
    public function finishedAction() {
        $datatable = $this->get('app.datatable.reparation');
        $datatable->buildDatatable(array('results' => 'finished'));

        return $this->render('reparation/finished.html.twig', array(
                    'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/finished_results", name="reparation_finished_results")
     */
    public function finishedResultsAction() {
        $datatable = $this->get('app.datatable.reparation');
        $datatable->buildDatatable(array('results' => 'finished'));
        
        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        $function = function($qb)
        {
            $qb->andWhere("state.id <> :st1");
            $qb->setParameter('st1', RepairState::PENDIENTE_PRESUPUESTACION);
            $qb->andWhere("state.id <> :st2");
            $qb->setParameter('st2', RepairState::PENDIENTE_APROBACION);
            $qb->andWhere("state.id <> :st3");
            $qb->setParameter('st3', RepairState::EN_REPARACION);
            
        };

        $query->addWhereAll($function);

        return $query->getResponse();
       
    }

    /**
     * Creates a new Reparation entity.
     *
     * @Route("/new/customer/{id}", name="reparation_new", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $reparation = new Reparation();
        $customerId = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $customer = $em->find('AppBundle\Entity\Customer', $customerId);
        $reparation->setCustomer($customer);
        
        $form = $this->createForm('AppBundle\Form\ReparationType', $reparation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reparation);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add(
                    'success', 'Los cambios fueron guardados correctamente'
            );

            return $this->redirectToRoute('reparation_show', array('id' => $reparation->getId()));
        }

        return $this->render('reparation/new.html.twig', array(
            'reparation' => $reparation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Reparation entity.
     *
     * @Route("/{id}", name="reparation_show", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction(Reparation $reparation)
    {
        $deleteForm = $this->createDeleteForm($reparation);

        return $this->render('reparation/show.html.twig', array(
            'reparation' => $reparation,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Finds and displays a Reparation entity.
     *
     * @Route("/{id}/export", name="reparation_export", options={"expose"=true})
     * @Method("GET")
     */
    public function exportAction(Reparation $reparation)
    {
        
         // Load PDF document from a file. 
        $fileName = 'PdfTemplates/reparacion.pdf'; 
        $pdf = Zend_Pdf::load($fileName);
        $pages = $pdf->pages; 
                
        $page = $pages[0];
        
        // Set font 
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 

        // Draw text 
        $page->drawText($reparation->getCustomer()->getName(), 155, 719); 
        $page->drawText($reparation->getCustomer()->getCuitDni(), 155, 697); 
        $page->drawText($reparation->getCustomer()->getAddress(), 155, 676); 
        $page->drawText($reparation->getCustomer()->getCity(), 155, 655); 
        $page->drawText($reparation->getCustomer()->getZipcode(), 290, 655); 
        $page->drawText($reparation->getCustomer()->getState(), 414, 655); 
        $page->drawText($reparation->getCustomer()->getPhones(), 155, 634); 
        
        $page->drawText(date('d/m/Y'), 190, 596); 
        
        $page->drawText($reparation->getId(), 155, 559); 

        $page->drawText($reparation->getBrand(), 155, 538); 
        $page->drawText($reparation->getModel(), 395, 538); 

        $page->drawText($reparation->getSeries(), 155, 516); 
        
        $page->drawText($reparation->getJoystick(), 155, 495);
        $page->drawText(($reparation->getBattery()) ? 'Sí' : 'No', 242, 495);
        $page->drawText(($reparation->getCharger()) ? 'Sí' : 'No', 396, 495);
        $page->drawText(($reparation->getCables()) ? 'Sí' : 'No', 484, 495);
        
        $page->drawText(($reparation->getEntryDate()) ? $reparation->getEntryDate()->format('d/m/Y') : '-', 155, 466);
        $page->drawText(($reparation->getEstimateDeliveryDate()) ? $reparation->getEstimateDeliveryDate()->format('d/m/Y') : '-', 330, 466);
        $page->drawText(($reparation->getEffectiveDeliveryDate()) ? $reparation->getEffectiveDeliveryDate()->format('d/m/Y') : '-', 484, 466);
        
        $lines = Reparation::separateStringInLines($reparation->getDiagnostic(), 80);
        $y = 435;
        $i = 1;
        foreach($lines as $line){
            if($i<=3){
                $page->drawText($line, 155, $y);
                $y-=10;
            }
            $i++;
        }
        
        
        
        $lines = Reparation::separateStringInLines($reparation->getClientDescription(), 80);
        $y = 395;
        $i = 1;
        foreach($lines as $line){
            if($i<=3){
                $page->drawText($line, 155, $y);
                $y-=10;
            }
            $i++;
        }
        
        
        $lines = Reparation::separateStringInLines($reparation->getTechnicalReport(), 80);
        $y = 355;
        $i = 1;
        foreach($lines as $line){
            if($i<=3){
                $page->drawText($line, 155, $y);
                $y-=10;
            }
            $i++;
        }
        
        $budget = '$ '. (is_null($reparation->getBudget()) ? '0' : $reparation->getBudget());
        $payment = '$ '. (is_null($reparation->getPayment()) ? '0' : $reparation->getPayment());
        
        $page->drawText($budget. ' .-' , 155, 312); 
        $page->drawText($payment . ' .-', 328, 312); 
        $page->drawText('$ ' . ($reparation->getBudget() - $reparation->getPayment()) . ' .-' , 484, 312); 
                       
        
        // Get PDF document as a string 
        $pdfData = $pdf->render(); 
        
        $name = $reparation->getId() . '-reparacion.pdf';

        header("Content-Disposition: inline; filename=$name"); 
        header("Content-type: application/x-pdf"); 
        echo $pdfData; 
        
 
    }

    /**
     * Displays a form to edit an existing Reparation entity.
     *
     * @Route("/{id}/edit", name="reparation_edit", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reparation $reparation)
    {
        $deleteForm = $this->createDeleteForm($reparation);
        $editForm = $this->createForm('AppBundle\Form\ReparationType', $reparation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reparation);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add(
                    'success', 'Los cambios fueron guardados correctamente'
            );

            return $this->redirectToRoute('reparation_show', array('id' => $reparation->getId()));
        }

        return $this->render('reparation/edit.html.twig', array(
            'reparation' => $reparation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Reparation entity.
     *
     * @Route("/{id}", name="reparation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Reparation $reparation)
    {
        $form = $this->createDeleteForm($reparation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reparation);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add(
                    'success', 'El elemento ha sido borrado.'
            );
        }

        return $this->redirectToRoute('reparation_index');
    }

    /**
     * Creates a form to delete a Reparation entity.
     *
     * @param Reparation $reparation The Reparation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reparation $reparation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reparation_delete', array('id' => $reparation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
