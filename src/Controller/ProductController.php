<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Gateway\ProductFamilyGateway;
use App\Gateway\ProductGateway;
use App\UseCase\ActivateProduct;
use App\UseCase\CreateProduct;
use App\UseCase\UpdateProduct;
use App\UseCase\ValidateProduct;
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
    private CreateProduct $createProduct;
    private UpdateProduct $updateProduct;
    private ActivateProduct $activateProduct;
    private ValidateProduct $validateProduct;
    private Security $security;
    private ProductFamilyGateway $productfamilyGateway;
    private ProductGateway $productGateway;

    /**
     * ProductController constructor.
     * @param CreateProduct $createProduct
     * @param UpdateProduct $updateProduct
     * @param ActivateProduct $activateProduct
     * @param ValidateProduct $validateProduct
     * @param Security $security
     * @param ProductFamilyGateway $productfamilyGateway
     * @param ProductGateway $productGateway
     */
    public function __construct(
        CreateProduct $createProduct,
        UpdateProduct $updateProduct,
        ActivateProduct $activateProduct,
        ValidateProduct $validateProduct,
        Security $security,
        ProductFamilyGateway $productfamilyGateway,
        ProductGateway $productGateway
    ) {
        $this->createProduct = $createProduct;
        $this->updateProduct = $updateProduct;
        $this->activateProduct = $activateProduct;
        $this->validateProduct = $validateProduct;
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
        $entity = new Product($this->productfamilyGateway->findOneById($productfamily));
        $form = $this->createForm(ProductType::class, $entity);

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
        $entity = new Product($this->productfamilyGateway->findOneById($productfamily));

        $user =  $this->security->getUser();

        $entity->setCreateBy($user);

        $form = $this->createForm(ProductType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createProduct->execute($entity);

            $this->addFlash('success', "Produit créé avec succès");
            return $this->redirectToRoute("product.show", ["id" => 1]);
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

        $form = $this->createForm(ProductType::class, $entity);

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

        $form = $this->createForm(ProductType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateProduct->execute($id);

            $this->addFlash('success', "Produit mise à jour avec succès");
            return $this->redirectToRoute("product.show", ["id" => 2]);
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

    public function __activate($entity, $status)
    {
        $entity->setActive($status);
        $user =  $this->security->getUser();
        $entity->setActivateBy($user);
        $entity->setActivateAt(new \DateTimeImmutable());
    }

    public function activate(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $this->__activate($entity, 1);

        $this->activateProduct->execute($id, 1);

        //var_export($entity);

        $this->addFlash('success', "Produit activé avec succès");
        return $this->redirectToRoute("product.show", ["id" => 1]);
    }

    public function disable(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $this->__activate($entity, 0);

        $this->activateProduct->execute($id, 0);

        $this->addFlash('success', "Produit désactivé avec succès");
        return $this->redirectToRoute("product.show", ["id" => 1]);
    }

    public function __validate($entity, $status)
    {
        $entity->setValid($status);
        $user =  $this->security->getUser();
        $entity->setValidateBy($user);
        $entity->setValidateAt(new \DateTimeImmutable());
    }

    public function validate(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $this->__validate($entity, 1);

        $this->validateProduct->execute($id, 1);

        //var_export($entity);

        $this->addFlash('success', "Produit validé avec succès");
        return $this->redirectToRoute("product.show", ["id" => 1]);
    }

    public function invalidate(int $id, Request $request)
    {
        $entity = $this->productGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $this->__validate($entity, 0);

        $this->validateProduct->execute($id, 0);

        $this->addFlash('success', "Produit invalidé avec succès");
        return $this->redirectToRoute("product.show", ["id" => 1]);
    }
}
