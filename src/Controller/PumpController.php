<?php

namespace App\Controller;

use App\Entity\Pump;
use App\Form\PumpType;
use App\Gateway\PumpGateway;
use App\Gateway\TankGateway;
use App\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Class PumpController
 * @package App\Controller
 */
class PumpController extends AbstractController
{
    private Security $security;
    private TankGateway $tankGateway;
    private PumpGateway $pumpGateway;

    /**
     * PumpController constructor.
     * @param Security $security
     * @param TankGateway $tankGateway
     * @param PumpGateway $pumpGateway
     */
    public function __construct(
        Security $security,
        TankGateway $tankGateway,
        PumpGateway $pumpGateway
    ) {
        $this->security = $security;
        $this->tankGateway = $tankGateway;
        $this->pumpGateway = $pumpGateway;
    }

    public function index()
    {
        $entities = $this->pumpGateway->findAll();
        return $this->render("ui/pump/index.html.twig", [
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

        $searchParam['entity'] = 'pump';

        //var_export($searchParam);
        //die(json_encode($valid));
        $entities = $this->pumpGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();

        return $this->render('ui/pump/ajax_list.html.twig', [
            'entities' => $entities,
            'pagination' => $pagination,
        ]);
    }

    public function new(int $tank)
    {
        $entity = $this->tankGateway->findOneById($tank);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $tank);
        }

        $entity = new Pump($entity);

        $form = $this->createForm($this->pumpGateway->getTypeClass(), $entity);

        return $this->render('ui/pump/new.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(int $tank, Request $request): Response
    {
        $entity = $this->tankGateway->findOneById($tank);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $tank);
        }
        $user = $this->security->getUser();

        $entity = new Pump($entity);

        $entity->setCreateBy($user);

        $form = $this->createForm($this->pumpGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pumpGateway->create($entity);
            $this->addFlash('success', "Pompe créée avec succès");

            return $this->redirectToRoute("pump.show", ["id" => ($entity->getId() ? $entity->getId() : 1)]);
        }

        return $this->render("ui/pump/create.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function edit(int $id)
    {
        $entity = $this->pumpGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la pompe  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $form = $this->createForm($this->pumpGateway->getTypeClass(), $entity);

        return $this->render('ui/pump/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function update(int $id, Request $request)
    {
        $entity = $this->pumpGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver la pompe d"id' . $id);
        }

        $user =  $this->security->getUser();

        $entity
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;

        $form = $this->createForm($this->pumpGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pumpGateway->update($entity);

            $this->addFlash('success', "Pompe mise à jour avec succès");
            return $this->redirectToRoute("pump.show", ["id" => $id]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/pump/update.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function show(int $id)
    {
        $entity = $this->pumpGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la pompe d'id  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $activateForm = $this->addForm($id);
        $disableForm = $this->addForm($id);
        $validateForm = $this->addForm($id);
        $invalidateForm = $this->addForm($id);

        return $this->render('ui/pump/show.html.twig', [
            'entity'      => $entity,
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
        $entities = $this->pumpGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->pumpGateway->activate($entity, true);
        }

        return new Response('1');
    }

    public function activateOne(int $id, Request $request)
    {
        $entity = $this->pumpGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la pompe d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pumpGateway->activate($entity, true);

            $this->addFlash('success', "Pompe activée avec succès");
        }

        return $this->redirectToRoute("pump.show", ["id" => $id]);
    }

    public function disable(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->pumpGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->pumpGateway->activate($entity, false);
        }

        return new Response('1');
    }

    public function disableOne(int $id, Request $request)
    {
        $entity = $this->pumpGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la pompe d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pumpGateway->activate($entity, false);

            $this->addFlash('success', "Pompe désactivée avec succès");
        }

        return $this->redirectToRoute("pump.show", ["id" => $id]);
    }

    public function validate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->pumpGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->pumpGateway->validate($entity, true);
        }

        return new Response('1');
    }

    public function validateOne(int $id, Request $request)
    {
        $entity = $this->pumpGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la pompe d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pumpGateway->validate($entity, true);

            $this->addFlash('success', "Pompe validée avec succès");
        }

        return $this->redirectToRoute("pump.show", ["id" => $id]);
    }

    public function invalidate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->pumpGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->pumpGateway->validate($entity, false);
        }

        return new Response('1');
    }

    public function invalidateOne(int $id, Request $request)
    {
        $entity = $this->pumpGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la pompe d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pumpGateway->validate($entity, false);

            $this->addFlash('success', "Pompe invalidée avec succès");
        }

        return $this->redirectToRoute("pump.show", ["id" => $id]);
    }

    public function remove(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->pumpGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->pumpGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('pump'));
    }

    public function delete(int $id, Request $request)
    {
        $entity = $this->pumpGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la pompe d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pumpGateway->remove($entity);

            $this->addFlash('success', "Pompe supprimée avec succès");
        }

        return $this->redirect($this->generateUrl('pump'));
    }

    private function addForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm()
            ;
    }
}
