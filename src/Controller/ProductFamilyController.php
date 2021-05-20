<?php

namespace App\Controller;

use App\Entity\ProductFamily;
use App\Form\ProductFamilyType;
use App\Gateway\TypeProductGateway;
use App\Gateway\ProductFamilyGateway;
use App\UseCase\ActivateProductFamily;
use App\UseCase\CreateProductFamily;
use App\UseCase\UpdateProductFamily;
use App\UseCase\ValidateProductFamily;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Class ProductFamilyController
 * @package App\Controller
 */
class ProductFamilyController extends AbstractController
{
    private CreateProductFamily $createProductFamily;
    private UpdateProductFamily $updateProductFamily;
    private ActivateProductFamily $activateProductFamily;
    private ValidateProductFamily $validateProductFamily;
    private Security $security;
    private TypeProductGateway $typeproductGateway;
    private ProductFamilyGateway $productfamilyGateway;

    /**
     * ProductFamilyController constructor.
     * @param CreateProductFamily $createProductFamily
     * @param UpdateProductFamily $updateProductFamily
     * @param ActivateProductFamily $activateProductFamily
     * @param ValidateProductFamily $validateProductFamily
     * @param Security $security
     * @param TypeProductGateway $typeproductGateway
     * @param ProductFamilyGateway $productfamilyGateway
     */
    public function __construct(
        CreateProductFamily $createProductFamily,
        UpdateProductFamily $updateProductFamily,
        ActivateProductFamily $activateProductFamily,
        ValidateProductFamily $validateProductFamily,
        Security $security,
        TypeProductGateway $typeproductGateway,
        ProductFamilyGateway $productfamilyGateway
    ) {
        $this->createProductFamily = $createProductFamily;
        $this->updateProductFamily = $updateProductFamily;
        $this->activateProductFamily = $activateProductFamily;
        $this->validateProductFamily = $validateProductFamily;
        $this->security = $security;
        $this->typeproductGateway = $typeproductGateway;
        $this->productfamilyGateway = $productfamilyGateway;
    }

    public function index()
    {
        $entities = $this->productfamilyGateway->findAll();
        return $this->render("ui/productfamily/index.html.twig", [
            "entities"  => $entities,
        ]);
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

        $form = $this->createForm(ProductFamilyType::class, $entity);

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

        $form = $this->createForm(ProductFamilyType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createProductFamily->execute($entity);

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

        $form = $this->createForm(ProductFamilyType::class, $entity);

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

        $form = $this->createForm(ProductFamilyType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateProductFamily->execute($entity);

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

    public function __activate($entity, $status)
    {
        $entity->setActive($status);
        $user =  $this->security->getUser();
        $entity->setActivateBy($user);
        $entity->setActivateAt(new \DateTimeImmutable());
    }

    public function activate(int $id, Request $request)
    {
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $this->__activate($entity, 1);

        $this->activateProductFamily->execute($entity, 1);

        //var_export($entity);

        $this->addFlash('success', "Famille activée avec succès");
        return $this->redirectToRoute("productfamily.show", ["id" => $id]);
    }

    public function disable(int $id, Request $request)
    {
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $this->__activate($entity, 0);

        $this->activateProductFamily->execute($entity, 0);

        $this->addFlash('success', "Famille désactivée avec succès");
        return $this->redirectToRoute("productfamily.show", ["id" => $id]);
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
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $this->__validate($entity, 1);

        $this->validateProductFamily->execute($entity, 1);

        //var_export($entity);

        $this->addFlash('success', "Famille validée avec succès");
        return $this->redirectToRoute("productfamily.show", ["id" => $id]);
    }

    public function invalidate(int $id, Request $request)
    {
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $this->__validate($entity, 0);

        $this->validateProductFamily->execute($entity, 0);

        $this->addFlash('success', "Famille invalidée avec succès");
        return $this->redirectToRoute("productfamily.show", ["id" => $id]);
    }
}
