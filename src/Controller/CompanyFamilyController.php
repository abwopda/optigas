<?php

namespace App\Controller;

use App\Entity\CompanyFamily;
use App\Form\CompanyFamilyType;
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
 * Class CompanyFamilyController
 * @package App\Controller
 */
class CompanyFamilyController extends AbstractController
{
    private Security $security;
    private TypeCompanyGateway $typecompanyGateway;
    private CompanyFamilyGateway $companyfamilyGateway;
    private CompanyGateway $companyGateway;

    /**
     * CompanyFamilyController constructor.
     * @param Security $security
     * @param TypeCompanyGateway $typecompanyGateway
     * @param CompanyFamilyGateway $companyfamilyGateway
     * @param CompanyGateway $companyGateway
     */
    public function __construct(
        Security $security,
        TypeCompanyGateway $typecompanyGateway,
        CompanyFamilyGateway $companyfamilyGateway,
        CompanyGateway $companyGateway
    ) {
        $this->security = $security;
        $this->typecompanyGateway = $typecompanyGateway;
        $this->companyfamilyGateway = $companyfamilyGateway;
        $this->companyGateway = $companyGateway;
    }

    public function index()
    {
        $entities = $this->companyfamilyGateway->findAll();
        return $this->render("ui/companyfamily/index.html.twig", [
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

        $searchParam['entity'] = 'companyfamily';

        //var_export($searchParam);
        //die(json_encode($valid));
        $entities = $this->companyfamilyGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();

        return $this->render('ui/companyfamily/ajax_list.html.twig', [
            'entities' => $entities,
            'pagination' => $pagination,
        ]);
    }

    public function ajaxcompaniesList(Request $request, $id)
    {
        $searchParam = $request->get('searchParam');
        $active = $request->get('active');
        $valid = $request->get('valid');
        $searchParam['active'] = $active;
        $searchParam['valid'] = $valid;
        $searchParam['entity'] = 'companyfamily';
        $searchParam['id'] = $id;
        //die(json_encode($searchParam));
        $entities = $this->companyGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();
        return $this->render('ui/companyfamily/ajax_companies_list.html.twig', array(
            'entities' => $entities,
            'pagination' => $pagination,
            'id' => 'company' . $id,
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */

    public function new(int $typecompany)
    {
        $entity = $this->typecompanyGateway->findOneById($typecompany);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type de produit d'id  " . $typecompany);
        }

        $entity = new CompanyFamily($entity);

        $form = $this->createForm($this->companyfamilyGateway->getTypeClass(), $entity);

        return $this->render('ui/companyfamily/new.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(int $typecompany, Request $request): Response
    {
        $entity = $this->typecompanyGateway->findOneById($typecompany);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le type de produit d'id  " . $typecompany);
        }

        $entity = new CompanyFamily($entity);

        $user =  $this->security->getUser();

        $entity->setCreateBy($user);

        $form = $this->createForm($this->companyfamilyGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyfamilyGateway->create($entity);

            $this->addFlash('success', "Famille créée avec succès");
            return $this->redirectToRoute("companyfamily.show", ["id" => ($entity->getId() ? $entity->getId() : 1)]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/companyfamily/create.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function edit(int $id)
    {
        $entity = $this->companyfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $form = $this->createForm($this->companyfamilyGateway->getTypeClass(), $entity);

        return $this->render('ui/companyfamily/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function update(int $id, Request $request)
    {
        $entity = $this->companyfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver la famille d"id' . $id);
        }

        $user =  $this->security->getUser();

        $entity
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;

        $form = $this->createForm($this->companyfamilyGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyfamilyGateway->update($entity);

            $this->addFlash('success', "Famille mise à jour avec succès");
            return $this->redirectToRoute("companyfamily.show", ["id" => $id]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/companyfamily/update.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function show(int $id)
    {
        $entity = $this->companyfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $activateForm = $this->addForm($id);
        $disableForm = $this->addForm($id);
        $validateForm = $this->addForm($id);
        $invalidateForm = $this->addForm($id);

        return $this->render("ui/companyfamily/show.html.twig", [
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
        $entity = $this->companyfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyfamilyGateway->activate($entity, true);

            $this->addFlash('success', "Famille activée avec succès");
        }

        return $this->redirectToRoute("companyfamily.show", ["id" => $id]);
    }

    public function disable(Request $request)
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
        $entity = $this->companyfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyfamilyGateway->activate($entity, false);

            $this->addFlash('success', "Famille désactivée avec succès");
        }

        return $this->redirectToRoute("companyfamily.show", ["id" => $id]);
    }

    public function validate(Request $request)
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
        $entity = $this->companyfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyfamilyGateway->validate($entity, true);

            $this->addFlash('success', "Famille validée avec succès");
        }

        return $this->redirectToRoute("companyfamily.show", ["id" => $id]);
    }

    public function invalidate(Request $request)
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
        $entity = $this->companyfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyfamilyGateway->validate($entity, false);

            $this->addFlash('success', "Famille invalidée avec succès");
        }

        return $this->redirectToRoute("companyfamily.show", ["id" => $id]);
    }

    public function remove(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->companyfamilyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->companyfamilyGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('companyfamily'));
    }

    public function removecompany(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->companyGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->companyGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('pos'));
    }

    public function delete(int $id, Request $request)
    {
        $entity = $this->companyfamilyGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la famille produit d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyfamilyGateway->remove($entity);

            $this->addFlash('success', "Famille produit supprimée avec succès");
        }

        return $this->redirect($this->generateUrl('companyfamily'));
    }

    private function addForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm()
            ;
    }
}
