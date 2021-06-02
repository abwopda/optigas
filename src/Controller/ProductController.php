<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Gateway\ProductFamilyGateway;
use App\Gateway\ProductGateway;
use App\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractController
{
    private Security $security;
    private ProductFamilyGateway $productfamilyGateway;
    private ProductGateway $productGateway;

    /**
     * ProductController constructor.
     * @param Security $security
     * @param ProductFamilyGateway $productfamilyGateway
     * @param ProductGateway $productGateway
     */
    public function __construct(
        Security $security,
        ProductFamilyGateway $productfamilyGateway,
        ProductGateway $productGateway
    ) {
        $this->security = $security;
        $this->productfamilyGateway = $productfamilyGateway;
        $this->productGateway = $productGateway;
    }

    public function index()
    {
        $entities = $this->productGateway->findAll();
        return $this->render("ui/product/index.html.twig", [
            "entities"  => $entities,
        ]);
    }

    public function ajaxList(Request $request)
    {
        $searchParam = $request->get('searchParam');

        //var_export($searchParam);
        //die(json_encode($valid));
        $entities = $this->productGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();

        return $this->render('ui/product/ajax_list.html.twig', [
            'entities' => $entities,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function new(int $productfamily)
    {
        $entity = $this->productfamilyGateway->findOneById($productfamily);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $productfamily);
        }

        $entity = new Product($entity);

        $form = $this->createForm($this->productGateway->getTypeClass(), $entity);

        return $this->render('ui/product/new.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(int $productfamily, Request $request): Response
    {
        $entity = $this->productfamilyGateway->findOneById($productfamily);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $productfamily);
        }

        $entity = new Product($entity);

        $user =  $this->security->getUser();

        $entity->setCreateBy($user);

        $form = $this->createForm($this->productGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productGateway->create($entity);

            $this->addFlash('success', "Produit créé avec succès");
            return $this->redirectToRoute("product.show", ["id" => ($entity->getId() ? $entity->getId() : 1)]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/product/create.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function edit(int $id)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $form = $this->createForm($this->productGateway->getTypeClass(), $entity);

        return $this->render('ui/product/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function update(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le produit d"id' . $id);
        }

        $user =  $this->security->getUser();

        $entity
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;

        $form = $this->createForm($this->productGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productGateway->update($entity);

            $this->addFlash('success', "Produit mise à jour avec succès");
            return $this->redirectToRoute("product.show", ["id" => $id]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/product/update.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function show(int $id)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $activateForm = $this->addForm($id);
        $disableForm = $this->addForm($id);
        $validateForm = $this->addForm($id);
        $invalidateForm = $this->addForm($id);

        return $this->render("ui/product/show.html.twig", [
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
        $entities = $this->productGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->productGateway->activate($entity, true);
        }

        return new Response('1');
    }

    public function activateOne(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productGateway->activate($entity, true);

            $this->addFlash('success', "Produit activé avec succès");
        }

        return $this->redirectToRoute("product.show", ["id" => $id]);
    }

    public function disable(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->productGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->productGateway->activate($entity, false);
        }

        return new Response('1');
    }

    public function disableOne(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productGateway->activate($entity, false);

            $this->addFlash('success', "Produit désactivé avec succès");
        }

        return $this->redirectToRoute("product.show", ["id" => $id]);
    }

    public function validate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->productGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->productGateway->validate($entity, true);
        }

        return new Response('1');
    }

    public function validateOne(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productGateway->validate($entity, true);

            $this->addFlash('success', "Produit validé avec succès");
        }

        return $this->redirectToRoute("product.show", ["id" => $id]);
    }

    public function invalidate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->productGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->productGateway->validate($entity, false);
        }

        return new Response('1');
    }

    public function invalidateOne(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productGateway->validate($entity, false);

            $this->addFlash('success', "Produit invalidé avec succès");
        }

        return $this->redirectToRoute("product.show", ["id" => $id]);
    }

    public function remove(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->productGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->productGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('product'));
    }

    public function delete(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productGateway->remove($entity);

            $this->addFlash('success', "Produit supprimé avec succès");
        }

        return $this->redirect($this->generateUrl('product'));
    }

    private function addForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm()
            ;
    }
}
