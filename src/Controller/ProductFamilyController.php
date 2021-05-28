<?php

namespace App\Controller;

use App\Entity\ProductFamily;
use App\Form\ProductFamilyType;
use App\Gateway\TypeProductGateway;
use App\Gateway\ProductFamilyGateway;
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
    private Security $security;
    private TypeProductGateway $typeproductGateway;
    private ProductFamilyGateway $productfamilyGateway;

    /**
     * ProductFamilyController constructor.
     * @param Security $security
     * @param TypeProductGateway $typeproductGateway
     * @param ProductFamilyGateway $productfamilyGateway
     */
    public function __construct(
        Security $security,
        TypeProductGateway $typeproductGateway,
        ProductFamilyGateway $productfamilyGateway
    ) {
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

    public function activate(int $id, Request $request)
    {
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $this->productfamilyGateway->activate($entity, true);

        $this->addFlash('success', "Famille activée avec succès");
        return $this->redirectToRoute("productfamily.show", ["id" => $id]);
    }

    public function disable(int $id, Request $request)
    {
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $this->productfamilyGateway->activate($entity, false);

        $this->addFlash('success', "Famille désactivée avec succès");
        return $this->redirectToRoute("productfamily.show", ["id" => $id]);
    }

    public function validate(int $id, Request $request)
    {
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $this->productfamilyGateway->validate($entity, true);

        $this->addFlash('success', "Famille validée avec succès");
        return $this->redirectToRoute("productfamily.show", ["id" => $id]);
    }

    public function invalidate(int $id, Request $request)
    {
        $entity = $this->productfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $this->productfamilyGateway->validate($entity, false);

        $this->addFlash('success', "Famille invalidée avec succès");
        return $this->redirectToRoute("productfamily.show", ["id" => $id]);
    }
}
