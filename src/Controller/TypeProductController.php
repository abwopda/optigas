<?php

namespace App\Controller;

use App\Entity\TypeProduct;
use App\Form\TypeProductType;
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
 * Class TypeProductController
 * @package App\Controller
 */
class TypeProductController extends AbstractController
{
    private TypeProductGateway $typeproductGateway;
    private ProductFamilyGateway $productfamilyGateway;
    private ProductGateway $productGateway;
    private Security $security;

    /**
     * TypeProductController constructor.
     * @param TypeProductGateway $typeproductGateway
     * @param ProductFamilyGateway $productfamilyGateway
     * @param ProductGateway $productGateway
     * @param Security $security
     */
    public function __construct(
        TypeProductGateway $typeproductGateway,
        ProductFamilyGateway $productfamilyGateway,
        ProductGateway $productGateway,
        Security $security
    ) {
        $this->typeproductGateway = $typeproductGateway;
        $this->productfamilyGateway = $productfamilyGateway;
        $this->productGateway = $productGateway;
        $this->security = $security;
    }


    public function index()
    {
        $entities = $this->typeproductGateway->findAll();
        return $this->render("ui/typeproduct/index.html.twig", [
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
        $entities = $this->typeproductGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();

        return $this->render('ui/typeproduct/ajax_list.html.twig', [
            'entities' => $entities,
            'pagination' => $pagination,
        ]);
    }

    public function ajaxfamiliesList(Request $request, $id)
    {
        $searchParam = $request->get('searchParamproductfamily');
        $active = $request->get('active');
        $valid = $request->get('valid');
        $searchParam['active'] = $active;
        $searchParam['valid'] = $valid;
        $searchParam['entity'] = 'typeproduct';
        $searchParam['id'] = $id;
        //die(json_encode($searchParam));
        $entities = $this->productfamilyGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();
        return $this->render('ui/typeproduct/ajax_families_list.html.twig', array(
            'entities' => $entities,
            'pagination' => $pagination,
            'id' => 'productfamily' . $id,
        ));
    }

    public function ajaxproductsList(Request $request, $id)
    {
        $searchParam = $request->get('searchParamproduct');
        $active = $request->get('active');
        $valid = $request->get('valid');
        $searchParam['active'] = $active;
        $searchParam['valid'] = $valid;
        $searchParam['entity'] = 'typeproduct';
        $searchParam['id'] = $id;
        //die(json_encode($searchParam));
        $entities = $this->productGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();
        return $this->render('ui/typeproduct/ajax_products_list.html.twig', array(
            'entities' => $entities,
            'pagination' => $pagination,
            'id' => 'product' . $id,
        ));
    }

    public function new()
    {
        $entity = new TypeProduct();
        $form = $this->createForm($this->typeproductGateway->getTypeClass(), $entity);

        return $this->render('ui/typeproduct/new.html.twig', [
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
        $entity = new TypeProduct();

        $user =  $this->security->getUser();

        $entity->setCreateBy($user);

        $form = $this->createForm($this->typeproductGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typeproductGateway->create($entity);
            //var_export($entity);
            $this->addFlash('success', "Type produit créé avec succès");
            return $this->redirectToRoute("typeproduct.show", ["id" => ($entity->getId() ? $entity->getId() : 1)]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/typeproduct/create.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function edit(int $id)
    {
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $form = $this->createForm($this->typeproductGateway->getTypeClass(), $entity);

        return $this->render('ui/typeproduct/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    public function update(int $id, Request $request)
    {
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le type produit d"id' . $id);
        }

        $user =  $this->security->getUser();

        $entity
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;

        $form = $this->createForm($this->typeproductGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typeproductGateway->update($entity);

            $this->addFlash('success', "Type produit mis à jour avec succès");
            return $this->redirectToRoute("typeproduct.show", ["id" => $id]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/typeproduct/update.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function show(int $id)
    {
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        return $this->render("ui/typeproduct/show.html.twig", [
            "entity"      => $entity,
        ]);
    }

    public function activate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->typeproductGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->typeproductGateway->activate($entity, true);
        }

        return new Response('1');
    }

    public function activatefamily(Request $request)
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
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $this->typeproductGateway->activate($entity, true);

        $this->addFlash('success', "Type produit activé avec succès");
        return $this->redirectToRoute("typeproduct.show", ["id" => $id]);
    }

    public function disable(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->typeproductGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->typeproductGateway->activate($entity, false);
        }

        return new Response('1');
    }

    public function disablefamily(Request $request)
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
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $this->typeproductGateway->activate($entity, false);

        $this->addFlash('success', "Type produit désactivé avec succès");
        return $this->redirectToRoute("typeproduct.show", ["id" => $id]);
    }

    public function validate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->typeproductGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->typeproductGateway->validate($entity, true);
        }

        return new Response('1');
    }

    public function validatefamily(Request $request)
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
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $this->typeproductGateway->validate($entity, true);

        $this->addFlash('success', "Type produit validé avec succès");
        return $this->redirectToRoute("typeproduct.show", ["id" => $id]);
    }

    public function invalidate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->typeproductGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->typeproductGateway->validate($entity, false);
        }

        return new Response('1');
    }

    public function invalidatefamily(Request $request)
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
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $this->typeproductGateway->validate($entity, false);

        $this->addFlash('success', "Type produit invalidé avec succès");
        return $this->redirectToRoute("typeproduct.show", ["id" => $id]);
    }

    public function remove(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->typeproductGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->typeproductGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('typeproduct'));
    }

    public function removefamily(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->productfamilyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->productfamilyGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('typeproduct'));
    }

    public function removeproduct(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->productGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->productGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('typeproduct'));
    }

    public function delete(int $id, Request $request)
    {
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typeproductGateway->remove($entity);

            $this->addFlash('success', "Type produit supprimé avec succès");
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
