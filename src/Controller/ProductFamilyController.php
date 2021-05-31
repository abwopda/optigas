<?php

namespace App\Controller;

use App\Entity\ProductFamily;
use App\Form\ProductFamilyType;
use App\Gateway\ProductGateway;
use App\Gateway\TypeProductGateway;
use App\Gateway\ProductFamilyGateway;
use App\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Class ProductFamilyController
 * @package App\Controller
 */
class ProductFamilyController extends AbstractController
{
    private Security $security;
    private TypeProductGateway $typeproductGateway;
    private ProductFamilyGateway $productfamilyGateway;
    private ProductGateway $productGateway;

    /**
     * ProductFamilyController constructor.
     * @param Security $security
     * @param TypeProductGateway $typeproductGateway
     * @param ProductFamilyGateway $productfamilyGateway
     * @param ProductGateway $productGateway
     */
    public function __construct(
        Security $security,
        TypeProductGateway $typeproductGateway,
        ProductFamilyGateway $productfamilyGateway,
        ProductGateway $productGateway
    ) {
        $this->security = $security;
        $this->typeproductGateway = $typeproductGateway;
        $this->productfamilyGateway = $productfamilyGateway;
        $this->productGateway = $productGateway;
    }

    public function index()
    {
        $entities = $this->productfamilyGateway->findAll();
        return $this->render("ui/productfamily/index.html.twig", [
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

        $searchParam['entity'] = 'productfamily';

        //var_export($searchParam);
        //die(json_encode($valid));
        $entities = $this->productfamilyGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();

        return $this->render('ui/productfamily/ajax_list.html.twig', [
            'entities' => $entities,
            'pagination' => $pagination,
        ]);
    }

    public function ajaxproductsList(Request $request, $id)
    {
        $searchParam = $request->get('searchParam');
        $active = $request->get('active');
        $valid = $request->get('valid');
        $searchParam['active'] = $active;
        $searchParam['valid'] = $valid;
        $searchParam['entity'] = 'productfamily';
        $searchParam['id'] = $id;
        //die(json_encode($searchParam));
        $entities = $this->productGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();
        return $this->render('ui/productfamily/ajax_products_list.html.twig', array(
            'entities' => $entities,
            'pagination' => $pagination,
            'id' => 'product' . $id,
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */

    public function new(int $typeproduct)
    {
        $entity = $this->typeproductGateway->findOneById($typeproduct);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type de produit d'id  " . $typeproduct);
        }

        $entity = new ProductFamily($entity);

        $form = $this->createForm($this->productfamilyGateway->getTypeClass(), $entity);

        return $this->render('ui/productfamily/new.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(int $typeproduct, Request $request): Response
    {
        $entity = $this->typeproductGateway->findOneById($typeproduct);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type de produit d'id  " . $typeproduct);
        }

        $entity = new ProductFamily($entity);

        $user =  $this->security->getUser();

        $entity->setCreateBy($user);

        $form = $this->createForm($this->productfamilyGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productfamilyGateway->create($entity);

            $this->addFlash('success', "Famille créée avec succès");
            return $this->redirectToRoute("productfamily.show", ["id" => ($entity->getId() ? $entity->getId() : 1)]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/productfamily/create.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function edit(int $id)
    {
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille  " . $id);
        }

        $form = $this->createForm($this->productfamilyGateway->getTypeClass(), $entity);

        return $this->render('ui/productfamily/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    public function update(int $id, Request $request)
    {
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver la famille d"id' . $id);
        }

        $user =  $this->security->getUser();

        $entity
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;

        $form = $this->createForm($this->productfamilyGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productfamilyGateway->update($entity);

            $this->addFlash('success', "Famille mise à jour avec succès");
            return $this->redirectToRoute("productfamily.show", ["id" => $id]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/productfamily/update.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function show(int $id)
    {
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        return $this->render('ui/productfamily/show.html.twig', [
            'entity'      => $entity,
        ]);
    }

    public function activate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->productfamilyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->productfamilyGateway->activate($entity, true);
        }

        return new Response('1');
    }

    public function activateproduct(Request $request)
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
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $this->productfamilyGateway->activate($entity, true);

        $this->addFlash('success', "Famille activée avec succès");
        return $this->redirectToRoute("productfamily.show", ["id" => $id]);
    }

    public function disable(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->productfamilyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->productfamilyGateway->activate($entity, false);
        }

        return new Response('1');
    }

    public function disableproduct(Request $request)
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
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $this->productfamilyGateway->activate($entity, false);

        $this->addFlash('success', "Famille désactivée avec succès");
        return $this->redirectToRoute("productfamily.show", ["id" => $id]);
    }

    public function validate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->productfamilyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->productfamilyGateway->validate($entity, true);
        }

        return new Response('1');
    }

    public function validateproduct(Request $request)
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
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $this->productfamilyGateway->validate($entity, true);

        $this->addFlash('success', "Famille validée avec succès");
        return $this->redirectToRoute("productfamily.show", ["id" => $id]);
    }

    public function invalidate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->productfamilyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->productfamilyGateway->validate($entity, false);
        }

        return new Response('1');
    }

    public function invalidateproduct(Request $request)
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
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $this->productfamilyGateway->validate($entity, false);

        $this->addFlash('success', "Famille invalidée avec succès");
        return $this->redirectToRoute("productfamily.show", ["id" => $id]);
    }

    public function remove(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->productfamilyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->productfamilyGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('productfamily'));
    }

    public function removeproduct(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->productGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->productGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('pos'));
    }

    public function delete(int $id, Request $request)
    {
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille produit d'id  " . $id);
        }

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productfamilyGateway->remove($entity);

            $this->addFlash('success', "Famille produit supprimée avec succès");
        }

        return $this->redirect($this->generateUrl('pos'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm()
            ;
    }
}
