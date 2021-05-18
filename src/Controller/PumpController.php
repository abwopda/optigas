<?php

namespace App\Controller;

use App\Entity\Pump;
use App\Form\PumpType;
use App\Gateway\PumpGateway;
use App\Gateway\TankGateway;
use App\UseCase\ActivatePump;
use App\UseCase\CreatePump;
use App\UseCase\UpdatePump;
use App\UseCase\ValidatePump;
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
    private ActivatePump $activatePump;
    private ValidatePump $validatePump;
    private Security $security;
    private TankGateway $tankGateway;
    private PumpGateway $pumpGateway;

    /**
     * PumpController constructor.
     * @param CreatePump $createPump
     * @param UpdatePump $updatePump
     * @param ActivatePump $activatePump
     * @param ValidatePump $validatePump
     * @param Security $security
     * @param TankGateway $tankGateway
     * @param PumpGateway $pumpGateway
     */
    public function __construct(
        CreatePump $createPump,
        UpdatePump $updatePump,
        ActivatePump $activatePump,
        ValidatePump $validatePump,
        Security $security,
        TankGateway $tankGateway,
        PumpGateway $pumpGateway
    ) {
        $this->createPump = $createPump;
        $this->updatePump = $updatePump;
        $this->activatePump = $activatePump;
        $this->validatePump = $validatePump;
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

    public function __activate($entity, $status)
    {
        $entity->setActive($status);
        $user =  $this->security->getUser();
        $entity->setActivateBy($user);
        $entity->setActivateAt(new \DateTimeImmutable());
    }

    public function activate(int $id, Request $request)
    {
        $entity = $this->pumpGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la pompe d'id  " . $id);
        }

        $this->__activate($entity, 1);

        $this->activatePump->execute($id, 1);

        //var_export($entity);

        $this->addFlash('success', "Pompe activée avec succès");
        return $this->redirectToRoute("pump.show", ["id" => 1]);
    }

    public function disable(int $id, Request $request)
    {
        $entity = $this->pumpGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la pompe d'id  " . $id);
        }

        $this->__activate($entity, 0);

        $this->activatePump->execute($id, 0);

        $this->addFlash('success', "Pompe désactivée avec succès");
        return $this->redirectToRoute("pump.show", ["id" => 1]);
    }

    public function __validate($entity, $status)
    {
        $entity->setValid($status);
        $user =  $this->security->getUser();
        $entity->setValidateBy($user);
        $entity->setValidateAt(new \DateTimeImmutable());
    }

    public function validate(int $id, Request $request)
    {
        $entity = $this->pumpGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la pompe d'id  " . $id);
        }

        $this->__validate($entity, 1);

        $this->validatePump->execute($id, 1);

        //var_export($entity);

        $this->addFlash('success', "Pompe validée avec succès");
        return $this->redirectToRoute("pump.show", ["id" => 1]);
    }

    public function invalidate(int $id, Request $request)
    {
        $entity = $this->pumpGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver la pompe d'id  " . $id);
        }

        $this->__validate($entity, 0);

        $this->validatePump->execute($id, 0);

        $this->addFlash('success', "Pompe invalidée avec succès");
        return $this->redirectToRoute("pump.show", ["id" => 1]);
    }
}
