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
        $fileName = 'reparacion.pdf'; 
        $pdf = Zend_Pdf::load($fileName);
        $pages = $pdf->pages; 
                
        $page = $pages[0];
        // Set font 
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 20); 

        // Draw text 
        $page->drawText('Hello world!', 100, 510); 
        
        
        // Get PDF document as a string 
        $pdfData = $pdf->render(); 

        header("Content-Disposition: inline; filename=reparacion.pdf"); 
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
