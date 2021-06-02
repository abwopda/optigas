<?php

namespace App\Controller;

use App\Entity\Pos;
use App\Gateway\PosGateway;
use App\Gateway\PumpGateway;
use App\Gateway\TankGateway;
use App\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Class PosController
 * @package App\Controller
 */
class PosController extends AbstractController
{
    private PosGateway $posGateway;
    private TankGateway $tankGateway;
    private PumpGateway $pumpGateway;
    private Security $security;

    /**
     * PosController constructor.
     * @param PosGateway $posGateway
     * @param TankGateway $tankGateway
     * @param PumpGateway $pumpGateway
     * @param Security $security
     */
    public function __construct(
        PosGateway $posGateway,
        TankGateway $tankGateway,
        PumpGateway $pumpGateway,
        Security $security
    ) {
        $this->posGateway = $posGateway;
        $this->tankGateway = $tankGateway;
        $this->pumpGateway = $pumpGateway;
        $this->security = $security;
    }


    public function index()
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_LIST', null, 'Cannot access this page');
        $entities = $this->posGateway->findAll();
        return $this->render("ui/pos/index.html.twig", [
            "entities"  => $entities,
        ]);
    }

    public function ajaxList(Request $request)
    {
        $searchParam = $request->get('searchParam');
        $active = $request->get('active');
        $valid = $request->get('valid');
        $searchParam['active'] = $active;
        $searchParam['valid'] = $valid;

        //var_export($searchParam);
        //die(json_encode($valid));
        $entities = $this->posGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();

        return $this->render('ui/pos/ajax_list.html.twig', [
            'entities' => $entities,
            'pagination' => $pagination,
        ]);
    }

    public function ajaxtanksList(Request $request, $id)
    {
        $searchParam = $request->get('searchParamtank');
        $active = $request->get('active');
        $valid = $request->get('valid');
        $searchParam['active'] = $active;
        $searchParam['valid'] = $valid;
        $searchParam['entity'] = 'pos';
        $searchParam['id'] = $id;
        //die(json_encode($searchParam));
        $entities = $this->tankGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();
        return $this->render('ui/pos/ajax_tanks_list.html.twig', array(
            'entities' => $entities,
            'pagination' => $pagination,
            'id' => 'tank' . $id,
        ));
    }

    public function ajaxpumpsList(Request $request, $id)
    {
        $searchParam = $request->get('searchParampump');
        $active = $request->get('active');
        $valid = $request->get('valid');
        $searchParam['active'] = $active;
        $searchParam['valid'] = $valid;
        $searchParam['entity'] = 'pos';
        $searchParam['id'] = $id;
        //die(json_encode($searchParam));
        $entities = $this->pumpGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();
        return $this->render('ui/pos/ajax_pumps_list.html.twig', array(
            'entities' => $entities,
            'pagination' => $pagination,
            'id' => 'pump' . $id,
        ));
    }

    public function new()
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_ADD', null, 'Cannot access this page');

        $entity = new Pos();
        $form = $this->createForm($this->posGateway->getTypeClass(), $entity);

        return $this->render('ui/pos/new.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_ADD', null, 'Cannot access this page');

        $entity = new Pos();

        $form = $this->createForm($this->posGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->posGateway->create($entity);

            //var_export($entity);

            $this->addFlash('success', "Point de vente créé avec succès");
            return $this->redirectToRoute("pos.show", ["id" => ($entity->getId() ? $entity->getId() : 1)]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/pos/create.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function edit(int $id)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_EDIT', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $form = $this->createForm($this->posGateway->getTypeClass(), $entity);

        return $this->render('ui/pos/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function update(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_EDIT', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le point de vente d"id' . $id);
        }

        $deleteForm = $this->addForm($id);
        $form = $this->createForm($this->posGateway->getTypeClass(), $entity)
            ->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->posGateway->update($entity);

            $this->addFlash('success', "Point de vente mis à jour avec succès");
            return $this->redirectToRoute("pos.show", ["id" => $id]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/pos/update.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function show(int $id)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_VIEW', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $activateForm = $this->addForm($id);
        $disableForm = $this->addForm($id);
        $validateForm = $this->addForm($id);
        $invalidateForm = $this->addForm($id);

        return $this->render("ui/pos/show.html.twig", [
            "entity"      => $entity,
            "delete_form" => $deleteForm->createView(),
            "activate_form" => $activateForm->createView(),
            "disable_form" => $disableForm->createView(),
            "validate_form" => $validateForm->createView(),
            "invalidate_form" => $invalidateForm->createView(),
        ]);
    }

    public function activate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->posGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->posGateway->activate($entity, true);
        }

        return new Response('1');
    }

    public function activatetank(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->tankGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->tankGateway->activate($entity, true);
        }

        return new Response('1');
    }

    public function activatepump(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->pumpGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->pumpGateway->activate($entity, true);
        }

        return new Response('1');
    }

    public function activateOne(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_ACTIVATE', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->posGateway->activate($entity, true);

            $this->addFlash('success', "Point de vente activé avec succès");
        }

        return $this->redirectToRoute("pos.show", ["id" => $id]);
    }

    public function disable(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->posGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->posGateway->activate($entity, false);
        }

        return new Response('1');
    }

    public function disabletank(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->tankGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->tankGateway->activate($entity, false);
        }

        return new Response('1');
    }

    public function disablepump(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->pumpGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->pumpGateway->activate($entity, false);
        }

        return new Response('1');
    }

    public function disableOne(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_ACTIVATE', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->posGateway->activate($entity, false);

            $this->addFlash('success', "Point de vente désactivé avec succès");
        }

        return $this->redirectToRoute("pos.show", ["id" => $id]);
    }

    public function validate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->posGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->posGateway->validate($entity, true);
        }

        return new Response('1');
    }

    public function validatetank(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->tankGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->tankGateway->validate($entity, true);
        }

        return new Response('1');
    }

    public function validatepump(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->pumpGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->pumpGateway->validate($entity, true);
        }

        return new Response('1');
    }

    public function validateOne(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_VALIDATE', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->posGateway->validate($entity, true);

            $this->addFlash('success', "Point de vente validé avec succès");
        }

        return $this->redirectToRoute("pos.show", ["id" => $id]);
    }

    public function invalidate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->posGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->posGateway->validate($entity, false);
        }

        return new Response('1');
    }

    public function invalidatetank(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->tankGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->tankGateway->validate($entity, false);
        }

        return new Response('1');
    }

    public function invalidatepump(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->pumpGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->pumpGateway->validate($entity, false);
        }

        return new Response('1');
    }

    public function invalidateOne(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_VALIDATE', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->posGateway->validate($entity, false);

            $this->addFlash('success', "Point de vente invalidé avec succès");
        }

        return $this->redirectToRoute("pos.show", ["id" => $id]);
    }

    public function remove(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->posGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->posGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('pos'));
    }

    public function removetank(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->tankGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->tankGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('pos'));
    }

    public function removepump(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->pumpGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->pumpGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('pos'));
    }

    public function delete(int $id, Request $request)
    {
        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->posGateway->remove($entity);

            $this->addFlash('success', "Point de vente supprimé avec succès");
        }

        return $this->redirect($this->generateUrl('pos'));
    }
    private function addForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm()
            ;
    }
}
