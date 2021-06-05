<?php

namespace App\Controller;

use App\Entity\TypeCompany;
use App\Form\TypeCompanyType;
use App\Gateway\CompanyGateway;
use App\Gateway\TypeCompanyGateway;
use App\Gateway\CompanyFamilyGateway;
use App\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Class TypeCompanyController
 * @package App\Controller
 */
class TypeCompanyController extends AbstractController
{
    private TypeCompanyGateway $typecompanyGateway;
    private CompanyFamilyGateway $companyfamilyGateway;
    private CompanyGateway $companyGateway;
    private Security $security;

    /**
     * TypeCompanyController constructor.
     * @param TypeCompanyGateway $typecompanyGateway
     * @param CompanyFamilyGateway $companyfamilyGateway
     * @param CompanyGateway $companyGateway
     * @param Security $security
     */
    public function __construct(
        TypeCompanyGateway $typecompanyGateway,
        CompanyFamilyGateway $companyfamilyGateway,
        CompanyGateway $companyGateway,
        Security $security
    ) {
        $this->typecompanyGateway = $typecompanyGateway;
        $this->companyfamilyGateway = $companyfamilyGateway;
        $this->companyGateway = $companyGateway;
        $this->security = $security;
    }


    public function index()
    {
        $entities = $this->typecompanyGateway->findAll();
        return $this->render("ui/typecompany/index.html.twig", [
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
        $entities = $this->typecompanyGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();

        return $this->render('ui/typecompany/ajax_list.html.twig', [
            'entities' => $entities,
            'pagination' => $pagination,
        ]);
    }

    public function ajaxfamiliesList(Request $request, $id)
    {
        $searchParam = $request->get('searchParamcompanyfamily');
        $active = $request->get('active');
        $valid = $request->get('valid');
        $searchParam['active'] = $active;
        $searchParam['valid'] = $valid;
        $searchParam['entity'] = 'typecompany';
        $searchParam['id'] = $id;
        //die(json_encode($searchParam));
        $entities = $this->companyfamilyGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();
        return $this->render('ui/typecompany/ajax_families_list.html.twig', array(
            'entities' => $entities,
            'pagination' => $pagination,
            'id' => 'companyfamily' . $id,
        ));
    }

    public function ajaxcompaniesList(Request $request, $id)
    {
        $searchParam = $request->get('searchParamcompany');
        $active = $request->get('active');
        $valid = $request->get('valid');
        $searchParam['active'] = $active;
        $searchParam['valid'] = $valid;
        $searchParam['entity'] = 'typecompany';
        $searchParam['id'] = $id;
        //die(json_encode($searchParam));
        $entities = $this->companyGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();
        return $this->render('ui/typecompany/ajax_companies_list.html.twig', array(
            'entities' => $entities,
            'pagination' => $pagination,
            'id' => 'company' . $id,
        ));
    }

    public function new()
    {
        $entity = new TypeCompany();
        $form = $this->createForm($this->typecompanyGateway->getTypeClass(), $entity);

        return $this->render('ui/typecompany/new.html.twig', [
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
        $entity = new TypeCompany();

        $user =  $this->security->getUser();

        $entity->setCreateBy($user);

        $form = $this->createForm($this->typecompanyGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typecompanyGateway->create($entity);
            //var_export($entity);
            $this->addFlash('success', "Type entreprise créée avec succès");
            return $this->redirectToRoute("typecompany.show", ["id" => ($entity->getId() ? $entity->getId() : 1)]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/typecompany/create.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function edit(int $id)
    {
        $entity = $this->typecompanyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type entreprise d'id  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $form = $this->createForm($this->typecompanyGateway->getTypeClass(), $entity);

        return $this->render('ui/typecompany/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function update(int $id, Request $request)
    {
        $entity = $this->typecompanyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le type entreprise d"id' . $id);
        }

        $user =  $this->security->getUser();

        $entity
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;

        $form = $this->createForm($this->typecompanyGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typecompanyGateway->update($entity);

            $this->addFlash('success', "Type entreprise mis à jour avec succès");
            return $this->redirectToRoute("typecompany.show", ["id" => $id]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/typecompany/update.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function show(int $id)
    {
        $entity = $this->typecompanyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type entreprise d'id  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $activateForm = $this->addForm($id);
        $disableForm = $this->addForm($id);
        $validateForm = $this->addForm($id);
        $invalidateForm = $this->addForm($id);

        return $this->render("ui/typecompany/show.html.twig", [
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
        $entities = $this->typecompanyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->typecompanyGateway->activate($entity, true);
        }

        return new Response('1');
    }

    public function activatefamily(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->companyfamilyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->companyfamilyGateway->activate($entity, true);
        }

        return new Response('1');
    }

    public function activatecompany(Request $request)
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
        $entity = $this->typecompanyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type entreprise d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typecompanyGateway->activate($entity, true);

            $this->addFlash('success', "Type entreprise activé avec succès");
        }

        return $this->redirectToRoute("typecompany.show", ["id" => $id]);
    }

    public function disable(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->typecompanyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->typecompanyGateway->activate($entity, false);
        }

        return new Response('1');
    }

    public function disablefamily(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->companyfamilyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->companyfamilyGateway->activate($entity, false);
        }

        return new Response('1');
    }

    public function disablecompany(Request $request)
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
        $entity = $this->typecompanyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type entreprise d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typecompanyGateway->activate($entity, false);

            $this->addFlash('success', "Type entreprise désactivé avec succès");
        }

        return $this->redirectToRoute("typecompany.show", ["id" => $id]);
    }

    public function validate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->typecompanyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->typecompanyGateway->validate($entity, true);
        }

        return new Response('1');
    }

    public function validatefamily(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->companyfamilyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->companyfamilyGateway->validate($entity, true);
        }

        return new Response('1');
    }

    public function validatecompany(Request $request)
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
        $entity = $this->typecompanyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type entreprise d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typecompanyGateway->validate($entity, true);

            $this->addFlash('success', "Type entreprise validé avec succès");
        }

        return $this->redirectToRoute("typecompany.show", ["id" => $id]);
    }

    public function invalidate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->typecompanyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->typecompanyGateway->validate($entity, false);
        }

        return new Response('1');
    }

    public function invalidatefamily(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->companyfamilyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->companyfamilyGateway->validate($entity, false);
        }

        return new Response('1');
    }

    public function invalidatecompany(Request $request)
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
        $entity = $this->typecompanyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type entreprise d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typecompanyGateway->validate($entity, false);

            $this->addFlash('success', "Type entreprise invalidé avec succès");
        }

        return $this->redirectToRoute("typecompany.show", ["id" => $id]);
    }

    public function remove(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->typecompanyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->typecompanyGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('typecompany'));
    }

    public function removefamily(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->companyfamilyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->companyfamilyGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('typecompany'));
    }

    public function removecompany(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->companyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->companyGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('typecompany'));
    }

    public function delete(int $id, Request $request)
    {
        $entity = $this->typecompanyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type entreprise d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typecompanyGateway->remove($entity);

            $this->addFlash('success', "Type entreprise supprimé avec succès");
        }

        return $this->redirect($this->generateUrl('typecompany'));
    }

    private function addForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm()
            ;
    }
}
