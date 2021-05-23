<?php

namespace App\Controller;

use App\Entity\TypeProduct;
use App\Form\TypeProductType;
use App\Gateway\TypeProductGateway;
use App\Gateway\TankGateway;
use App\UseCase\ActivateTypeProduct;
use App\UseCase\ValidateTypeProduct;
use App\UseCase\CreateTypeProduct;
use App\UseCase\UpdateTypeProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Class TypeProductController
 * @package App\Controller
 */
class TypeProductController extends AbstractController
{
    private CreateTypeProduct $createTypeProduct;
    private UpdateTypeProduct $updateTypeProduct;
    private ActivateTypeProduct $activateTypeProduct;
    private ValidateTypeProduct $validateTypeProduct;
    private TypeProductGateway $typeproductGateway;
    private TankGateway $tankGateway;
    private Security $security;

    /**
     * TypeProductController constructor.
     * @param CreateTypeProduct $createTypeProduct
     * @param UpdateTypeProduct $updateTypeProduct
     * @param ActivateTypeProduct $activateTypeProduct
     * @param ValidateTypeProduct $validateTypeProduct ;
     * @param TypeProductGateway $typeproductGateway
     * @param TankGateway $tankGateway
     * @param Security $security
     */
    public function __construct(
        CreateTypeProduct $createTypeProduct,
        UpdateTypeProduct $updateTypeProduct,
        ActivateTypeProduct $activateTypeProduct,
        ValidateTypeProduct $validateTypeProduct,
        TypeProductGateway $typeproductGateway,
        TankGateway $tankGateway,
        Security $security
    ) {
        $this->createTypeProduct = $createTypeProduct;
        $this->updateTypeProduct = $updateTypeProduct;
        $this->activateTypeProduct = $activateTypeProduct;
        $this->validateTypeProduct = $validateTypeProduct;
        $this->typeproductGateway = $typeproductGateway;
        $this->tankGateway = $tankGateway;
        $this->security = $security;
    }


    public function index()
    {
        $entities = $this->typeproductGateway->findAll();
        return $this->render("ui/typeproduct/index.html.twig", [
            "entities"  => $entities,
        ]);
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
            $this->createTypeProduct->execute($entity);
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
            $this->updateTypeProduct->execute($entity);

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

    public function activate(int $id, Request $request)
    {
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $this->activateTypeProduct->execute($entity, true);

        $this->addFlash('success', "Type produit activé avec succès");
        return $this->redirectToRoute("typeproduct.show", ["id" => $id]);
    }

    public function disable(int $id, Request $request)
    {
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $this->activateTypeProduct->execute($entity, false);

        $this->addFlash('success', "Type produit désactivé avec succès");
        return $this->redirectToRoute("typeproduct.show", ["id" => $id]);
    }

    public function validate(int $id, Request $request)
    {
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $this->validateTypeProduct->execute($entity, true);

        $this->addFlash('success', "Type produit validé avec succès");
        return $this->redirectToRoute("typeproduct.show", ["id" => $id]);
    }

    public function invalidate(int $id, Request $request)
    {
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $this->validateTypeProduct->execute($entity, false);

        $this->addFlash('success', "Type produit invalidé avec succès");
        return $this->redirectToRoute("typeproduct.show", ["id" => $id]);
    }
}
