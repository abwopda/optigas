<?php

namespace App\Controller;

use App\Entity\Pos;
use App\Form\PosType;
use App\Gateway\PosGateway;
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
    private PosGateway $posGateway;
    private Security $security;

    /**
     * PosController constructor.
     * @param CreatePos $createPos
     * @param UpdatePos $updatePos
     * @param PosGateway $posGateway
     * @param Security $security
     */
    public function __construct(
        CreatePos $createPos,
        UpdatePos $updatePos,
        PosGateway $posGateway,
        Security $security
    ) {
        $this->createPos = $createPos;
        $this->updatePos = $updatePos;
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
            throw $this->createNotFoundException('Impossible de trouver le point de vente d"id' . $id);
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
            //var_export($entity);
            $this->addFlash('success', "Point de vente mis à jour avec succès");
            return $this->redirectToRoute("pos.show", ["id" => 1]);
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
            throw $this->createNotFoundException('Impossible de trouver le point de vente d"id' . $id);
        }

        return $this->render('ui/pos/show.html.twig', [
            'entity'      => $entity,
        ]);
    }
}
