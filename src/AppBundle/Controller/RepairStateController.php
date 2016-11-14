<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\RepairState;
use AppBundle\Form\RepairStateType;

/**
 * RepairState controller.
 *
 * @Route("/admin/repairstate")
 */
class RepairStateController extends Controller
{
    /**
     * Lists all RepairState entities.
     *
     * @Route("/", name="repairstate_index")
     * @Method("GET")
     */
    public function indexAction() {
        $datatable = $this->get('app.datatable.repairstate');
        $datatable->buildDatatable();

        return $this->render('repairstate/index.html.twig', array(
                    'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="repairstate_results")
     */
    public function indexResultsAction() {
        $datatable = $this->get('app.datatable.repairstate');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new RepairState entity.
     *
     * @Route("/new", name="repairstate_new", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $repairState = new RepairState();
        $form = $this->createForm('AppBundle\Form\RepairStateType', $repairState);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($repairState);
            $em->flush();

            return $this->redirectToRoute('repairstate_show', array('id' => $repairState->getId()));
        }

        return $this->render('repairstate/new.html.twig', array(
            'repairState' => $repairState,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a RepairState entity.
     *
     * @Route("/{id}", name="repairstate_show", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction(RepairState $repairState)
    {
        $deleteForm = $this->createDeleteForm($repairState);

        return $this->render('repairstate/show.html.twig', array(
            'repairState' => $repairState,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing RepairState entity.
     *
     * @Route("/{id}/edit", name="repairstate_edit", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RepairState $repairState)
    {
        $deleteForm = $this->createDeleteForm($repairState);
        $editForm = $this->createForm('AppBundle\Form\RepairStateType', $repairState);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($repairState);
            $em->flush();

            return $this->redirectToRoute('repairstate_edit', array('id' => $repairState->getId()));
        }

        return $this->render('repairstate/edit.html.twig', array(
            'repairState' => $repairState,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a RepairState entity.
     *
     * @Route("/{id}", name="repairstate_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RepairState $repairState)
    {
        $form = $this->createDeleteForm($repairState);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($repairState);
            $em->flush();
        }

        return $this->redirectToRoute('repairstate_index');
    }

    /**
     * Creates a form to delete a RepairState entity.
     *
     * @param RepairState $repairState The RepairState entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RepairState $repairState)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('repairstate_delete', array('id' => $repairState->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
