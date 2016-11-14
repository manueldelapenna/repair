<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ReparationPayment;
use AppBundle\Form\ReparationPaymentType;

/**
 * ReparationPayment controller.
 *
 * @Route("/admin/reparationpayment")
 */
class ReparationPaymentController extends Controller
{
    /**
     * Lists all ReparationPayment entities.
     *
     * @Route("/", name="reparationpayment_index")
     * @Method("GET")
     */
    public function indexAction() {
        $datatable = $this->get('app.datatable.reparationpayment');
        $datatable->buildDatatable();

        return $this->render('reparationpayment/index.html.twig', array(
                    'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="reparationpayment_results")
     */
    public function indexResultsAction() {
        $datatable = $this->get('app.datatable.reparationpayment');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new ReparationPayment entity.
     *
     * @Route("/new", name="reparationpayment_new", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $reparationPayment = new ReparationPayment();
        $form = $this->createForm('AppBundle\Form\ReparationPaymentType', $reparationPayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reparationPayment);
            $em->flush();

            return $this->redirectToRoute('reparationpayment_show', array('id' => $reparationPayment->getId()));
        }

        return $this->render('reparationpayment/new.html.twig', array(
            'reparationPayment' => $reparationPayment,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ReparationPayment entity.
     *
     * @Route("/{id}", name="reparationpayment_show", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction(ReparationPayment $reparationPayment)
    {
        $deleteForm = $this->createDeleteForm($reparationPayment);

        return $this->render('reparationpayment/show.html.twig', array(
            'reparationPayment' => $reparationPayment,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ReparationPayment entity.
     *
     * @Route("/{id}/edit", name="reparationpayment_edit", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ReparationPayment $reparationPayment)
    {
        $deleteForm = $this->createDeleteForm($reparationPayment);
        $editForm = $this->createForm('AppBundle\Form\ReparationPaymentType', $reparationPayment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reparationPayment);
            $em->flush();

            return $this->redirectToRoute('reparationpayment_edit', array('id' => $reparationPayment->getId()));
        }

        return $this->render('reparationpayment/edit.html.twig', array(
            'reparationPayment' => $reparationPayment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ReparationPayment entity.
     *
     * @Route("/{id}", name="reparationpayment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ReparationPayment $reparationPayment)
    {
        $form = $this->createDeleteForm($reparationPayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reparationPayment);
            $em->flush();
        }

        return $this->redirectToRoute('reparationpayment_index');
    }

    /**
     * Creates a form to delete a ReparationPayment entity.
     *
     * @param ReparationPayment $reparationPayment The ReparationPayment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ReparationPayment $reparationPayment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reparationpayment_delete', array('id' => $reparationPayment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
