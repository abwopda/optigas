<?php

namespace App\Controller;

use App\Entity\Pos;
use App\Form\PosType;
use App\Gateway\PosGateway;
use App\UseCase\ActivatePos;
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
    private PosGateway $posGateway;
    private Security $security;

    /**
     * PosController constructor.
     * @param CreatePos $createPos
     * @param UpdatePos $updatePos
     * @param ActivatePos $activatePos
     * @param PosGateway $posGateway
     * @param Security $security
     */
    public function __construct(
        CreatePos $createPos,
        UpdatePos $updatePos,
        ActivatePos $activatePos,
        PosGateway $posGateway,
        Security $security
    ) {
        $this->createPos = $createPos;
        $this->updatePos = $updatePos;
        $this->activatePos = $activatePos;
        $this->posGateway = $posGateway;
        $this->security = $security;
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

        $user =  $this->security->getUser();

        $entity->setCreateBy($user);

        $form = $this->createForm(PosType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createPos->execute($entity);
            //var_export($entity);
            $this->addFlash('success', "Point de vente créé avec succès");
            return $this->redirectToRoute("pos.show", ["id" => 1]);
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

        $user =  $this->security->getUser();

        $entity
            ->setUpdateBy($user)
            ->setUpdateAt(new \DateTimeImmutable())
        ;

        $form = $this->createForm(PosType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updatePos->execute($id);

            $this->addFlash('success', "Point de vente mis à jour avec succès");
            return $this->redirectToRoute("pos.show", ["id" => 2]);
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

        return $this->render('ui/pos/show.html.twig', [
            'entity'      => $entity,
        ]);
    }
    public function __activate($entity, $status)
    {
        $entity->setActive($status);
        $user =  $this->security->getUser();
        $entity->setActivateBy($user);
        $entity->setActivateAt(new \DateTimeImmutable());
    }

    public function activate(int $id, Request $request)
    {
        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $this->__activate($entity, 1);

        $this->activatePos->execute($id, 1);

        //var_export($entity);

        $this->addFlash('success', "Point de vente activé avec succès");
        return $this->redirectToRoute("pos.show", ["id" => 1]);
    }

    public function disable(int $id, Request $request)
    {
        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $this->__activate($entity, 0);

        $this->activatePos->execute($id, 0);

        $this->addFlash('success', "Point de vente désactivé avec succès");
        return $this->redirectToRoute("pos.show", ["id" => 1]);
    }
}
