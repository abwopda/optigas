<?php

namespace App\Controller;

use App\Entity\Pos;
use App\Form\PosType;
use App\Gateway\PosGateway;
use App\Gateway\TankGateway;
use App\UseCase\ActivatePos;
use App\UseCase\ValidatePos;
use App\UseCase\CreatePos;
use App\UseCase\UpdatePos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Class PosController
 * @package App\Controller
 */
class PosController extends AbstractController
{
    private CreatePos $createPos;
    private UpdatePos $updatePos;
    private ActivatePos $activatePos;
    private ValidatePos $validatePos;
    private PosGateway $posGateway;
    private TankGateway $tankGateway;
    private Security $security;

    /**
     * PosController constructor.
     * @param CreatePos $createPos
     * @param UpdatePos $updatePos
     * @param ActivatePos $activatePos
     * @param ValidatePos $validatePos ;
     * @param PosGateway $posGateway
     * @param TankGateway $tankGateway
     * @param Security $security
     */
    public function __construct(
        CreatePos $createPos,
        UpdatePos $updatePos,
        ActivatePos $activatePos,
        ValidatePos $validatePos,
        PosGateway $posGateway,
        TankGateway $tankGateway,
        Security $security
    ) {
        $this->createPos = $createPos;
        $this->updatePos = $updatePos;
        $this->activatePos = $activatePos;
        $this->validatePos = $validatePos;
        $this->posGateway = $posGateway;
        $this->tankGateway = $tankGateway;
        $this->security = $security;
    }


    public function index()
    {
        $entities = $this->posGateway->findAll();
        return $this->render("ui/pos/index.html.twig", [
            "entities"  => $entities,
        ]);
    }

    public function new()
    {
        $entity = new Pos();
        $form = $this->createForm(PosType::class, $entity);

        return $this->render('ui/pos/new.html.twig', [
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
        $entity = new Pos();

        $form = $this->createForm(PosType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createPos->execute($entity);

            //var_export($entity);

            $this->addFlash('success', "Point de vente créé avec succès");
            return $this->redirectToRoute("pos.show", ["id" => ($entity->getId() ? $entity->getId() : 1)]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/pos/create.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function edit(int $id)
    {
        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $form = $this->createForm(PosType::class, $entity);

        return $this->render('ui/pos/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    public function update(int $id, Request $request)
    {
        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le point de vente d"id' . $id);
        }

        $form = $this->createForm(PosType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updatePos->execute($entity);

            $this->addFlash('success', "Point de vente mis à jour avec succès");
            return $this->redirectToRoute("pos.show", ["id" => $id]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/pos/update.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function show(int $id)
    {
        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        return $this->render("ui/pos/show.html.twig", [
            "entity"      => $entity,
        ]);
    }

    public function activate(int $id, Request $request)
    {
        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $this->activatePos->execute($entity, true);

        $this->addFlash('success', "Point de vente activé avec succès");
        return $this->redirectToRoute("pos.show", ["id" => $id]);
    }

    public function disable(int $id, Request $request)
    {
        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $this->activatePos->execute($entity, false);

        $this->addFlash('success', "Point de vente désactivé avec succès");
        return $this->redirectToRoute("pos.show", ["id" => $id]);
    }

    public function validate(int $id, Request $request)
    {
        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $this->validatePos->execute($entity, true);

        $this->addFlash('success', "Point de vente validé avec succès");
        return $this->redirectToRoute("pos.show", ["id" => $id]);
    }

    public function invalidate(int $id, Request $request)
    {
        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $this->validatePos->execute($entity, false);

        $this->addFlash('success', "Point de vente invalidé avec succès");
        return $this->redirectToRoute("pos.show", ["id" => $id]);
    }
}
