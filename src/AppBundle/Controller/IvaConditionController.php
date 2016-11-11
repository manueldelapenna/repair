<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\IvaCondition;
use AppBundle\Form\IvaConditionType;

/**
 * IvaCondition controller.
 *
 * @Route("/admin/iva_condition")
 */
class IvaConditionController extends Controller {

    /**
     * Lists all IvaCondition entities.
     *
     * @Route("/", name="iva_condition_index")
     * @Method("GET")
     */
    public function indexAction() {
        $datatable = $this->get('app.datatable.iva_condition');
        $datatable->buildDatatable();

        return $this->render('iva_condition/index.html.twig', array(
                    'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="iva_condition_results")
     */
    public function indexResultsAction() {
        $datatable = $this->get('app.datatable.iva_condition');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new IvaCondition entity.
     *
     * @Route("/new", name="iva_condition_new", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $ivaCondition = new IvaCondition();
        $form = $this->createForm('AppBundle\Form\IvaConditionType', $ivaCondition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ivaCondition);
            $em->flush();

            return $this->redirectToRoute('iva_condition_show', array('id' => $ivaCondition->getId()));
        }

        return $this->render('iva_condition/new.html.twig', array(
                    'ivaCondition' => $ivaCondition,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a IvaCondition entity.
     *
     * @Route("/{id}", name="iva_condition_show", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction(IvaCondition $ivaCondition) {
        $deleteForm = $this->createDeleteForm($ivaCondition);

        return $this->render('iva_condition/show.html.twig', array(
                    'ivaCondition' => $ivaCondition,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing IvaCondition entity.
     *
     * @Route("/{id}/edit", name="iva_condition_edit", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, IvaCondition $ivaCondition) {
        $deleteForm = $this->createDeleteForm($ivaCondition);
        $editForm = $this->createForm('AppBundle\Form\IvaConditionType', $ivaCondition);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ivaCondition);
            $em->flush();

            return $this->redirectToRoute('iva_condition_edit', array('id' => $ivaCondition->getId()));
        }

        return $this->render('iva_condition/edit.html.twig', array(
                    'ivaCondition' => $ivaCondition,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a IvaCondition entity.
     *
     * @Route("/{id}", name="iva_condition_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, IvaCondition $ivaCondition) {
        $form = $this->createDeleteForm($ivaCondition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ivaCondition);
            $em->flush();
        }

        return $this->redirectToRoute('iva_condition_index');
    }

    /**
     * Creates a form to delete a IvaCondition entity.
     *
     * @param IvaCondition $ivaCondition The IvaCondition entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(IvaCondition $ivaCondition) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('iva_condition_delete', array('id' => $ivaCondition->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
