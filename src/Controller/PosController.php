<?php

namespace App\Controller;

use App\Entity\Pos;
use App\Gateway\PosGateway;
use App\Gateway\TankGateway;
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
    private PosGateway $posGateway;
    private TankGateway $tankGateway;
    private Security $security;

    /**
     * PosController constructor.
     * @param PosGateway $posGateway
     * @param TankGateway $tankGateway
     * @param Security $security
     */
    public function __construct(
        PosGateway $posGateway,
        TankGateway $tankGateway,
        Security $security
    ) {
        $this->posGateway = $posGateway;
        $this->tankGateway = $tankGateway;
        $this->security = $security;
    }


    public function index()
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_LIST', null, 'Cannot access this page');
        $entities = $this->posGateway->findAll();
        return $this->render("ui/pos/index.html.twig", [
            "entities"  => $entities,
        ]);
    }

    public function new()
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_ADD', null, 'Cannot access this page');

        $entity = new Pos();
        $form = $this->createForm($this->posGateway->getTypeClass(), $entity);

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
        //$this->denyAccessUnlessGranted('ROLE_POS_ADD', null, 'Cannot access this page');

        $entity = new Pos();

        $form = $this->createForm($this->posGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->posGateway->create($entity);

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
        //$this->denyAccessUnlessGranted('ROLE_POS_EDIT', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $form = $this->createForm($this->posGateway->getTypeClass(), $entity);

        return $this->render('ui/pos/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    public function update(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_EDIT', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le point de vente d"id' . $id);
        }

        $form = $this->createForm($this->posGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->posGateway->update($entity);

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
        //$this->denyAccessUnlessGranted('ROLE_POS_VIEW', null, 'Cannot access this page');

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
        //$this->denyAccessUnlessGranted('ROLE_POS_ACTIVATE', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $this->posGateway->activate($entity, true);

        $this->addFlash('success', "Point de vente activé avec succès");
        return $this->redirectToRoute("pos.show", ["id" => $id]);
    }

    public function disable(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_ACTIVATE', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $this->posGateway->activate($entity, false);

        $this->addFlash('success', "Point de vente désactivé avec succès");
        return $this->redirectToRoute("pos.show", ["id" => $id]);
    }

    public function validate(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_VALIDATE', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $this->posGateway->validate($entity, true);

        $this->addFlash('success', "Point de vente validé avec succès");
        return $this->redirectToRoute("pos.show", ["id" => $id]);
    }

    public function invalidate(int $id, Request $request)
    {
        //$this->denyAccessUnlessGranted('ROLE_POS_VALIDATE', null, 'Cannot access this page');

        $entity = $this->posGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le point de vente d'id  " . $id);
        }

        $this->posGateway->validate($entity, false);

        $this->addFlash('success', "Point de vente invalidé avec succès");
        return $this->redirectToRoute("pos.show", ["id" => $id]);
    }
}
