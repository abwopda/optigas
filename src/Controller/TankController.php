<?php

namespace App\Controller;

use App\Entity\Tank;
use App\Form\TankType;
use App\Gateway\PosGateway;
use App\Gateway\PumpGateway;
use App\Gateway\TankGateway;
use App\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Class TankController
 * @package App\Controller
 */
class TankController extends AbstractController
{
    private Security $security;
    private PosGateway $posGateway;
    private TankGateway $tankGateway;
    private PumpGateway $pumpGateway;

    /**
     * TankController constructor.
     * @param Security $security
     * @param PosGateway $posGateway
     * @param TankGateway $tankGateway
     * @param PumpGateway $pumpGateway
     */
    public function __construct(
        Security $security,
        PosGateway $posGateway,
        TankGateway $tankGateway,
        PumpGateway $pumpGateway
    ) {
        $this->security = $security;
        $this->posGateway = $posGateway;
        $this->tankGateway = $tankGateway;
        $this->pumpGateway = $pumpGateway;
    }

    public function index()
    {
        //$this->denyAccessUnlessGranted('ROLE_TANK_LIST', null, 'Cannot access this page');

        $entities = $this->tankGateway->findAll();
        return $this->render("ui/tank/index.html.twig", [
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

        $searchParam['entity'] = 'tank';

        //var_export($searchParam);
        //die(json_encode($valid));

        $entities = $this->tankGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();

        return $this->render('ui/tank/ajax_list.html.twig', [
            'entities' => $entities,
            'pagination' => $pagination,
        ]);
    }

    public function ajaxpumpsList(Request $request, $id)
    {
        $searchParam = $request->get('searchParam');
        $active = $request->get('active');
        $valid = $request->get('valid');
        $searchParam['active'] = $active;
        $searchParam['valid'] = $valid;
        $searchParam['entity'] = 'tank';
        $searchParam['id'] = $id;
        //die(json_encode($searchParam));
        $entities = $this->pumpGateway->search($searchParam);
        $pagination = (new Paginator())
            ->setItems(count($entities), $searchParam['perPage'])
            ->setPage($searchParam['page'])->toArray();
        return $this->render('ui/tank/ajax_pumps_list.html.twig', array(
            'entities' => $entities,
            'pagination' => $pagination,
            'id' => 'pump' . $id,
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */

    public function new(int $pos)
    {
        //$this->denyAccessUnlessGranted('ROLE_TANK_ADD', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($pos);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $pos);
        }

        $entity = new Tank($entity);
        $form = $this->createForm($this->tankGateway->getTypeClass(), $entity);

        return $this->render('ui/tank/new.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(int $pos, Request $request): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_TANK_ADD', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($pos);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $pos);
        }
        $user =  $this->security->getUser();

        $entity = new Tank($entity);

        $entity->setCreateBy($user);

        $form = $this->createForm($this->tankGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tankGateway->create($entity);

            $this->addFlash('success', "Cuve créée avec succès");
            return $this->redirectToRoute("tank.show", ["id" => ($entity->getId() ? $entity->getId() : 1)]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/tank/create.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function edit(int $id)
    {
        //$this->denyAccessUnlessGranted('ROLE_TANK_EDIT', null, 'Cannot access this page');

        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $form = $this->createForm($this->tankGateway->getTypeClass(), $entity);

        return $this->render('ui/tank/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function update(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_TANK_EDIT', null, 'Cannot access this page');

        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver la cuve d"id' . $id);
        }

        $user =  $this->security->getUser();

        $entity
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;

        $form = $this->createForm($this->tankGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tankGateway->update($entity);

            $this->addFlash('success', "Cuve mise à jour avec succès");
            return $this->redirectToRoute("tank.show", ["id" => $id]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/tank/update.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function show(int $id)
    {
        //$this->denyAccessUnlessGranted('ROLE_TANK_VIEW', null, 'Cannot access this page');

        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $deleteForm = $this->addForm($id);
        $activateForm = $this->addForm($id);
        $disableForm = $this->addForm($id);
        $validateForm = $this->addForm($id);
        $invalidateForm = $this->addForm($id);

        return $this->render('ui/tank/show.html.twig', [
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
        $entities = $this->tankGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->tankGateway->activate($entity, true);
        }

        return new Response('1');
    }

    public function activatepump(Request $request)
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
        //$this->denyAccessUnlessGranted('ROLE_TANK_ACTIVATE', null, 'Cannot access this page');

        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tankGateway->activate($entity, true);

            $this->addFlash('success', "Cuve activée avec succès");
        }

        return $this->redirectToRoute("tank.show", ["id" => $id]);
    }

    public function disable(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->tankGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->tankGateway->activate($entity, false);
        }

        return new Response('1');
    }

    public function disablepump(Request $request)
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
        //$this->denyAccessUnlessGranted('ROLE_TANK_ACTIVATE', null, 'Cannot access this page');

        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tankGateway->activate($entity, false);

            $this->addFlash('success', "Cuve désactivée avec succès");
        }

        return $this->redirectToRoute("tank.show", ["id" => $id]);
    }

    public function validate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->tankGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->tankGateway->validate($entity, true);
        }

        return new Response('1');
    }

    public function validatepump(Request $request)
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
        //$this->denyAccessUnlessGranted('ROLE_TANK_VALIDATE', null, 'Cannot access this page');

        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tankGateway->validate($entity, true);

            $this->addFlash('success', "Cuve validée avec succès");
        }

        return $this->redirectToRoute("tank.show", ["id" => $id]);
    }

    public function invalidate(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->tankGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->tankGateway->validate($entity, false);
        }

        return new Response('1');
    }

    public function invalidatepump(Request $request)
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
        //$this->denyAccessUnlessGranted('ROLE_TANK_VALIDATE', null, 'Cannot access this page');

        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tankGateway->validate($entity, false);

            $this->addFlash('success', "Cuve invalidée avec succès");
        }

        return $this->redirectToRoute("tank.show", ["id" => $id]);
    }

    public function remove(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->tankGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->tankGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('tank'));
    }

    public function removepump(Request $request)
    {
        $ids = $request->get('entities');
        $entities = $this->pumpGateway->search(array('ids' => $ids));
        foreach ($entities as $entity) {
            $this->pumpGateway->remove($entity);
        }

        return $this->redirect($this->generateUrl('tank'));
    }

    public function delete(int $id, Request $request)
    {
        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $form = $this->addForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tankGateway->remove($entity);

            $this->addFlash('success', "Cuve supprimée avec succès");
        }

        return $this->redirect($this->generateUrl('tank'));
    }

    private function addForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm()
            ;
    }
}
