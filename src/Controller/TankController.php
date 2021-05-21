<?php

namespace App\Controller;

use App\Entity\Tank;
use App\Form\TankType;
use App\Gateway\PosGateway;
use App\Gateway\TankGateway;
use App\UseCase\ActivateTank;
use App\UseCase\CreateTank;
use App\UseCase\UpdateTank;
use App\UseCase\ValidateTank;
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
    private CreateTank $createTank;
    private UpdateTank $updateTank;
    private ActivateTank $activateTank;
    private ValidateTank $validateTank;
    private Security $security;
    private PosGateway $posGateway;
    private TankGateway $tankGateway;

    /**
     * TankController constructor.
     * @param CreateTank $createTank
     * @param UpdateTank $updateTank
     * @param ActivateTank $activateTank
     * @param ValidateTank $validateTank
     * @param Security $security
     * @param PosGateway $posGateway
     * @param TankGateway $tankGateway
     */
    public function __construct(
        CreateTank $createTank,
        UpdateTank $updateTank,
        ActivateTank $activateTank,
        ValidateTank $validateTank,
        Security $security,
        PosGateway $posGateway,
        TankGateway $tankGateway
    ) {
        $this->createTank = $createTank;
        $this->updateTank = $updateTank;
        $this->activateTank = $activateTank;
        $this->validateTank = $validateTank;
        $this->security = $security;
        $this->posGateway = $posGateway;
        $this->tankGateway = $tankGateway;
    }

    public function index()
    {
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
        $entity = $this->posGateway->findOneById($pos);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $pos);
        }

        $entity = new Tank($entity);
        $form = $this->createForm(TankType::class, $entity);

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
        $entity = $this->posGateway->findOneById($pos);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $pos);
        }
        $user =  $this->security->getUser();

        $entity = new Tank($entity);

        $entity->setCreateBy($user);

        $form = $this->createForm(TankType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createTank->execute($entity);

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
        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve  " . $id);
        }

        $form = $this->createForm(TankType::class, $entity);

        return $this->render('ui/tank/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    public function update(int $id, Request $request)
    {
        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver la cuve d"id' . $id);
        }

        $user =  $this->security->getUser();

        $entity
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;

        $form = $this->createForm(TankType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateTank->execute($entity);

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
        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $this->activateTank->execute($entity, true);

        $this->addFlash('success', "Cuve activée avec succès");
        return $this->redirectToRoute("tank.show", ["id" => $id]);
    }

    public function disable(int $id, Request $request)
    {
        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $this->activateTank->execute($entity, false);

        $this->addFlash('success', "Cuve désactivée avec succès");
        return $this->redirectToRoute("tank.show", ["id" => $id]);
    }

    public function validate(int $id, Request $request)
    {
        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $this->validateTank->execute($entity, true);

        $this->addFlash('success', "Cuve validée avec succès");
        return $this->redirectToRoute("tank.show", ["id" => $id]);
    }

    public function invalidate(int $id, Request $request)
    {
        $entity = $this->tankGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la cuve d'id  " . $id);
        }

        $this->validateTank->execute($entity, false);

        $this->addFlash('success', "Cuve invalidée avec succès");
        return $this->redirectToRoute("tank.show", ["id" => $id]);
    }
}
