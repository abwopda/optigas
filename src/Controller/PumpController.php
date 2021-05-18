<?php

namespace App\Controller;

use App\Entity\Pump;
use App\Form\PumpType;
use App\Gateway\PumpGateway;
use App\Gateway\TankGateway;
use App\UseCase\CreatePump;
use App\UseCase\UpdatePump;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Class PumpController
 * @package App\Controller
 */
class PumpController extends AbstractController
{
    private CreatePump $createPump;
    private UpdatePump $updatePump;
    private Security $security;
    private TankGateway $tankGateway;
    private PumpGateway $pumpGateway;

    /**
     * PumpController constructor.
     * @param CreatePump $createPump
     * @param UpdatePump $updatePump
     * @param Security $security
     * @param TankGateway $tankGateway
     * @param PumpGateway $pumpGateway
     */
    public function __construct(
        CreatePump $createPump,
        UpdatePump $updatePump,
        Security $security,
        TankGateway $tankGateway,
        PumpGateway $pumpGateway
    ) {
        $this->createPump = $createPump;
        $this->updatePump = $updatePump;
        $this->security = $security;
        $this->tankGateway = $tankGateway;
        $this->pumpGateway = $pumpGateway;
    }

    public function new(int $tank)
    {
        $entity = new Pump($this->tankGateway->findOneById($tank));
        $form = $this->createForm(PumpType::class, $entity);

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
        $pump = new Pump($this->tankGateway->findOneById($tank));

        $user = $this->security->getUser();

        $pump->setCreateBy($user);

        $form = $this->createForm(PumpType::class, $pump)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createPump->execute($pump);
            $this->addFlash('success', "Pompe créée avec succès");

            return $this->redirectToRoute("pump.show", ["id" => 1]);
        }

        return $this->render("ui/pump/create.html.twig", [
            "entity" => $pump,
            "form" => $form->createView()
        ]);
    }

    public function edit(int $id)
    {
        $entity = $this->pumpGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la pompe  " . $id);
        }

        $form = $this->createForm(PumpType::class, $entity);

        return $this->render('ui/pump/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
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

        $form = $this->createForm(PumpType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updatePump->execute($id);

            $this->addFlash('success', "Pompe mise à jour avec succès");
            return $this->redirectToRoute("pump.show", ["id" => 2]);
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

        return $this->render('ui/pump/show.html.twig', [
            'entity'      => $entity,
        ]);
    }
}
