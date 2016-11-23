<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Reparation;
use AppBundle\Entity\Customer;
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
        $datatable->buildDatatable();

        return $this->render('reparation/index.html.twig', array(
                    'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="reparation_results")
     */
    public function indexResultsAction() {
        $datatable = $this->get('app.datatable.reparation');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

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
