<?php

namespace App\Controller;

use App\Entity\TypeProduct;
use App\Form\TypeProductType;
use App\Gateway\TypeProductGateway;
use App\Gateway\TankGateway;
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
    private TypeProductGateway $typeproductGateway;
    private TankGateway $tankGateway;
    private Security $security;

    /**
     * TypeProductController constructor.
     * @param TypeProductGateway $typeproductGateway
     * @param TankGateway $tankGateway
     * @param Security $security
     */
    public function __construct(
        TypeProductGateway $typeproductGateway,
        TankGateway $tankGateway,
        Security $security
    ) {
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

    public function activate(int $id, Request $request)
    {
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $this->typeproductGateway->activate($entity, true);

        $this->addFlash('success', "Type produit activé avec succès");
        return $this->redirectToRoute("typeproduct.show", ["id" => $id]);
    }

    public function disable(int $id, Request $request)
    {
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $this->typeproductGateway->activate($entity, false);

        $this->addFlash('success', "Type produit désactivé avec succès");
        return $this->redirectToRoute("typeproduct.show", ["id" => $id]);
    }

    public function validate(int $id, Request $request)
    {
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $this->typeproductGateway->validate($entity, true);

        $this->addFlash('success', "Type produit validé avec succès");
        return $this->redirectToRoute("typeproduct.show", ["id" => $id]);
    }

    public function invalidate(int $id, Request $request)
    {
        $entity = $this->typeproductGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type produit d'id  " . $id);
        }

        $this->typeproductGateway->validate($entity, false);

        $this->addFlash('success', "Type produit invalidé avec succès");
        return $this->redirectToRoute("typeproduct.show", ["id" => $id]);
    }
}
