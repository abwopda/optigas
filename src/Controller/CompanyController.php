<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Gateway\CompanyFamilyGateway;
use App\Gateway\CompanyGateway;
use App\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Class CompanyController
 * @package App\Controller
 */
class CompanyController extends AbstractController
{
    private Security $security;
    private CompanyFamilyGateway $companyfamilyGateway;
    private CompanyGateway $companyGateway;

    /**
     * CompanyController constructor.
     * @param Security $security
     * @param CompanyFamilyGateway $companyfamilyGateway
     * @param CompanyGateway $companyGateway
     */
    public function __construct(
        Security $security,
        CompanyFamilyGateway $companyfamilyGateway,
        CompanyGateway $companyGateway
    ) {
        $this->security = $security;
        $this->companyfamilyGateway = $companyfamilyGateway;
        $this->companyGateway = $companyGateway;
    }

    public function index()
    {
        $entities = $this->companyGateway->findAll();
        return $this->render("ui/company/index.html.twig", [
            "entities"  => $entities,
        ]);
    }

    public function ajaxList(Request $request)
    {
        $searchParam = $request->get('searchParam');

        //var_export($searchParam);
        //die(json_encode($valid));
        $entities = $this->companyGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();

        return $this->render('ui/company/ajax_list.html.twig', [
            'entities' => $entities,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function new()
    {
        $entity = new Company();

        $form = $this->createForm($this->companyGateway->getTypeClass(), $entity);

        return $this->render('ui/company/new.html.twig', [
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
        $entity = new Company();

        $user =  $this->security->getUser();

        $entity->setCreateBy($user);

        $form = $this->createForm($this->companyGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyGateway->create($entity);

            $this->addFlash('success', "Entreprise créée avec succès");
            return $this->redirectToRoute("company.show", ["id" => ($entity->getId() ? $entity->getId() : 1)]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/company/create.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function edit(int $id)
    {
        $entity = $this->companyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $form = $this->createForm($this->companyGateway->getTypeClass(), $entity);

        return $this->render('ui/company/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function update(int $id, Request $request)
    {
        $entity = $this->companyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le produit d"id' . $id);
        }

        $user =  $this->security->getUser();

        $entity
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;

        $form = $this->createForm($this->companyGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyGateway->update($entity);

            $this->addFlash('success', "Entreprise mise à jour avec succès");
            return $this->redirectToRoute("company.show", ["id" => $id]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/company/update.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function show(int $id)
    {
        $entity = $this->companyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $activateForm = $this->addForm($id);
        $disableForm = $this->addForm($id);
        $validateForm = $this->addForm($id);
        $invalidateForm = $this->addForm($id);

        return $this->render("ui/company/show.html.twig", [
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
        $entities = $this->companyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->companyGateway->activate($entity, true);
        }

        return new Response('1');
    }

    public function activateOne(int $id, Request $request)
    {
        $entity = $this->companyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyGateway->activate($entity, true);

            $this->addFlash('success', "Entreprise activée avec succès");
        }

        return $this->redirectToRoute("company.show", ["id" => $id]);
    }

    public function disable(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->companyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->companyGateway->activate($entity, false);
        }

        return new Response('1');
    }

    public function disableOne(int $id, Request $request)
    {
        $entity = $this->companyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyGateway->activate($entity, false);

            $this->addFlash('success', "Entreprise désactivée avec succès");
        }

        return $this->redirectToRoute("company.show", ["id" => $id]);
    }

    public function validate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->companyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->companyGateway->validate($entity, true);
        }

        return new Response('1');
    }

    public function validateOne(int $id, Request $request)
    {
        $entity = $this->companyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyGateway->validate($entity, true);

            $this->addFlash('success', "Entreprise validée avec succès");
        }

        return $this->redirectToRoute("company.show", ["id" => $id]);
    }

    public function invalidate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->companyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->companyGateway->validate($entity, false);
        }

        return new Response('1');
    }

    public function invalidateOne(int $id, Request $request)
    {
        $entity = $this->companyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyGateway->validate($entity, false);

            $this->addFlash('success', "Entreprise invalidée avec succès");
        }

        return $this->redirectToRoute("company.show", ["id" => $id]);
    }

    public function remove(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->companyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->companyGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('company'));
    }

    public function delete(int $id, Request $request)
    {
        $entity = $this->companyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le produit d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyGateway->remove($entity);

            $this->addFlash('success', "Entreprise supprimée avec succès");
        }

        return $this->redirect($this->generateUrl('company'));
    }

    private function addForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm()
            ;
    }
}
