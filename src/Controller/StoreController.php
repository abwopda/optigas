<?php

namespace App\Controller;

use App\Entity\Store;
use App\Gateway\PosGateway;
use App\Gateway\ProductGateway;
use App\Gateway\StoreGateway;
use App\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Class StoreController
 * @package App\Controller
 */
class StoreController extends AbstractController
{
    private StoreGateway $storeGateway;
    private ProductGateway $productGateway;
    private PosGateway $posGateway;
    private Security $security;

    /**
     * StoreController constructor.
     * @param StoreGateway $storeGateway
     * @param ProductGateway $productGateway
     * @param PosGateway $posGateway
     * @param Security $security
     */
    public function __construct(
        StoreGateway $storeGateway,
        ProductGateway $productGateway,
        PosGateway $posGateway,
        Security $security
    ) {
        $this->storeGateway = $storeGateway;
        $this->productGateway = $productGateway;
        $this->posGateway = $posGateway;
        $this->security = $security;
    }


    public function index()
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_LIST', null, 'Cannot access this page');
        $entities = $this->storeGateway->findAll();
        return $this->render("ui/store/index.html.twig", [
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
        $entities = $this->storeGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();

        return $this->render('ui/store/ajax_list.html.twig', [
            'entities' => $entities,
            'pagination' => $pagination,
        ]);
    }

    public function ajaxproductsList(Request $request, $id)
    {
        $searchParam = $request->get('searchParamproduct');
        $active = $request->get('active');
        $valid = $request->get('valid');
        $searchParam['active'] = $active;
        $searchParam['valid'] = $valid;
        $searchParam['entity'] = 'store';
        $searchParam['id'] = $id;
        //die(json_encode($searchParam));
        $entities = $this->productGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();
        return $this->render('ui/store/ajax_products_list.html.twig', array(
            'entities' => $entities,
            'pagination' => $pagination,
            'id' => 'product' . $id,
        ));
    }

    public function ajaxpossList(Request $request, $id)
    {
        $searchParam = $request->get('searchParampos');
        $active = $request->get('active');
        $valid = $request->get('valid');
        $searchParam['active'] = $active;
        $searchParam['valid'] = $valid;
        $searchParam['entity'] = 'store';
        $searchParam['id'] = $id;
        //die(json_encode($searchParam));
        $entities = $this->posGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();
        return $this->render('ui/store/ajax_poss_list.html.twig', array(
            'entities' => $entities,
            'pagination' => $pagination,
            'id' => 'pos' . $id,
        ));
    }

    public function new()
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_ADD', null, 'Cannot access this page');

        $entity = new Store();
        $form = $this->createForm($this->storeGateway->getTypeClass(), $entity);

        return $this->render('ui/store/new.html.twig', [
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

        $entity = new Store();

        $form = $this->createForm($this->storeGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->storeGateway->create($entity);

            //var_export($entity);

            $this->addFlash('success', "Depot créé avec succès");
            return $this->redirectToRoute("store.show", ["id" => ($entity->getId() ? $entity->getId() : 1)]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/store/create.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function edit(int $id)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_EDIT', null, 'Cannot access this page');

        $entity = $this->storeGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le depot d'id  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $form = $this->createForm($this->storeGateway->getTypeClass(), $entity);

        return $this->render('ui/store/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function update(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_EDIT', null, 'Cannot access this page');

        $entity = $this->storeGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le depot d"id' . $id);
        }

        $deleteForm = $this->addForm($id);
        $form = $this->createForm($this->storeGateway->getTypeClass(), $entity)
            ->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->storeGateway->update($entity);

            $this->addFlash('success', "Depot mis à jour avec succès");
            return $this->redirectToRoute("store.show", ["id" => $id]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/store/update.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function show(int $id)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_VIEW', null, 'Cannot access this page');

        $entity = $this->storeGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le depot d'id  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $activateForm = $this->addForm($id);
        $disableForm = $this->addForm($id);
        $validateForm = $this->addForm($id);
        $invalidateForm = $this->addForm($id);

        return $this->render("ui/store/show.html.twig", [
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
        $entities = $this->storeGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->storeGateway->activate($entity, true);
        }

        return new Response('1');
    }

    public function activateOne(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_ACTIVATE', null, 'Cannot access this page');

        $entity = $this->storeGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le depot d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->storeGateway->activate($entity, true);

            $this->addFlash('success', "Depot activé avec succès");
        }

        return $this->redirectToRoute("store.show", ["id" => $id]);
    }

    public function disable(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->storeGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->storeGateway->activate($entity, false);
        }

        return new Response('1');
    }

    public function disableOne(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_ACTIVATE', null, 'Cannot access this page');

        $entity = $this->storeGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le depot d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->storeGateway->activate($entity, false);

            $this->addFlash('success', "Depot désactivé avec succès");
        }

        return $this->redirectToRoute("store.show", ["id" => $id]);
    }

    public function validate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->storeGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->storeGateway->validate($entity, true);
        }

        return new Response('1');
    }

    public function validateOne(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_VALIDATE', null, 'Cannot access this page');

        $entity = $this->storeGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le depot d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->storeGateway->validate($entity, true);

            $this->addFlash('success', "Depot validé avec succès");
        }

        return $this->redirectToRoute("store.show", ["id" => $id]);
    }

    public function invalidate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->storeGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->storeGateway->validate($entity, false);
        }

        return new Response('1');
    }

    public function invalidateOne(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_VALIDATE', null, 'Cannot access this page');

        $entity = $this->storeGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le depot d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->storeGateway->validate($entity, false);

            $this->addFlash('success', "Depot invalidé avec succès");
        }

        return $this->redirectToRoute("store.show", ["id" => $id]);
    }

    public function remove(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->storeGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->storeGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('store'));
    }

    public function delete(int $id, Request $request)
    {
        $entity = $this->storeGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le depot d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->storeGateway->remove($entity);

            $this->addFlash('success', "Depot supprimé avec succès");
        }

        return $this->redirect($this->generateUrl('store'));
    }
    private function addForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm()
            ;
    }
}
