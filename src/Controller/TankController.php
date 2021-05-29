<?php

namespace App\Controller;

use App\Entity\Tank;
use App\Form\TankType;
use App\Gateway\PosGateway;
use App\Gateway\TankGateway;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    /**
     * TankController constructor.
     * @param Security $security
     * @param PosGateway $posGateway
     * @param TankGateway $tankGateway
     */
    public function __construct(
        Security $security,
        PosGateway $posGateway,
        TankGateway $tankGateway
    ) {
        $this->security = $security;
        $this->posGateway = $posGateway;
        $this->tankGateway = $tankGateway;
    }

    public function index()
    {
        //$this->denyAccessUnlessGranted('ROLE_TANK_LIST', null, 'Cannot access this page');

        $entities = $this->tankGateway->findAll();
        return $this->render("ui/tank/index.html.twig", [
            "entities"  => $entities,
        ]);
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

        $form = $this->createForm($this->tankGateway->getTypeClass(), $entity);

        return $this->render('ui/tank/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
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

        return $this->render('ui/tank/show.html.twig', [
            'entity'      => $entity,
        ]);
    }

    public function activate(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_TANK_ACTIVATE', null, 'Cannot access this page');

        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $this->tankGateway->activate($entity, true);

        $this->addFlash('success', "Cuve activée avec succès");
        return $this->redirectToRoute("tank.show", ["id" => $id]);
    }

    public function disable(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_TANK_ACTIVATE', null, 'Cannot access this page');

        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $this->tankGateway->activate($entity, false);

        $this->addFlash('success', "Cuve désactivée avec succès");
        return $this->redirectToRoute("tank.show", ["id" => $id]);
    }

    public function validate(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_TANK_VALIDATE', null, 'Cannot access this page');

        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $this->tankGateway->validate($entity, true);

        $this->addFlash('success', "Cuve validée avec succès");
        return $this->redirectToRoute("tank.show", ["id" => $id]);
    }

    public function invalidate(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_TANK_VALIDATE', null, 'Cannot access this page');

        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $this->tankGateway->validate($entity, false);

        $this->addFlash('success', "Cuve invalidée avec succès");
        return $this->redirectToRoute("tank.show", ["id" => $id]);
    }
}
