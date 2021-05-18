<?php

namespace App\Controller;

use App\Entity\Pos;
use App\Entity\Tank;
use App\Form\TankType;
use App\Gateway\PosGateway;
use App\Gateway\TankGateway;
use App\UseCase\CreateTank;
use App\UseCase\UpdateTank;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

/**
 * Class TankController
 * @package App\Controller
 */
class TankController extends AbstractController
{
    private CreateTank $createTank;
    private UpdateTank $updateTank;
    private Security $security;
    private PosGateway $posGateway;
    private TankGateway $tankGateway;

    /**
     * TankController constructor.
     * @param CreateTank $createTank
     * @param UpdateTank $updateTank
     * @param Security $security
     * @param PosGateway $posGateway
     * @param TankGateway $tankGateway
     */
    public function __construct(
        CreateTank $createTank,
        UpdateTank $updateTank,
        Security $security,
        PosGateway $posGateway,
        TankGateway $tankGateway
    ) {
        $this->createTank = $createTank;
        $this->updateTank = $updateTank;
        $this->security = $security;
        $this->posGateway = $posGateway;
        $this->tankGateway = $tankGateway;
    }


    /**
     * @param Request $request
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function new(int $pos)
    {
        $entity = new Tank($this->posGateway->findOneById($pos));
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
        $entity = new Tank($this->posGateway->findOneById($pos));

        $user =  $this->security->getUser();

        $entity->setCreateBy($user);

        $form = $this->createForm(TankType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createTank->execute($entity);

            $this->addFlash('success', "Cuve créée avec succès");
            return $this->redirectToRoute("tank.show", ["id" => 1]);
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
            $this->updateTank->execute($id);

            $this->addFlash('success', "Cuve mise à jour avec succès");
            return $this->redirectToRoute("tank.show", ["id" => 2]);
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
}
