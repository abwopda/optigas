<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Gateway\ProductFamilyGateway;
use App\Gateway\ProductGateway;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        $form = $this->createForm($this->productGateway->getTypeClass(), $entity);

        return $this->render('ui/product/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
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

        return $this->render('ui/product/show.html.twig', [
            'entity'      => $entity,
        ]);
    }

    public function activate(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $this->productGateway->activate($entity, true);

        $this->addFlash('success', "Produit activé avec succès");

        return $this->redirectToRoute("product.show", ["id" => $id]);
    }

    public function disable(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $this->productGateway->activate($entity, false);

        $this->addFlash('success', "Produit désactivé avec succès");
        return $this->redirectToRoute("product.show", ["id" => $id]);
    }

    public function validate(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $this->productGateway->validate($entity, true);

        $this->addFlash('success', "Produit validé avec succès");
        return $this->redirectToRoute("product.show", ["id" => $id]);
    }

    public function invalidate(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $this->productGateway->validate($entity, false);

        $this->addFlash('success', "Produit invalidé avec succès");
        return $this->redirectToRoute("product.show", ["id" => $id]);
    }
}
