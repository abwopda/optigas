<?php

namespace App\Controller;

use App\Entity\Pos;
use App\Entity\Tank;
use App\Form\TankType;
use App\Gateway\PosGateway;
use App\UseCase\CreateTank;
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
    private Security $security;
    private PosGateway $posGateway;

    /**
     * TankController constructor.
     * @param CreateTank $createTank
     * @param Security $security
     * @param PosGateway $posGateway
     */
    public function __construct(
        CreateTank $createTank,
        Security $security,
        PosGateway $posGateway
    ) {
        $this->createTank = $createTank;
        $this->security = $security;
        $this->posGateway = $posGateway;
    }


    /**
     * @param Request $request
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function create(int $pos, Request $request): Response
    {
        $tank = new Tank($this->posGateway->findOneById($pos));

        $user = $this->security->getUser();

        $tank->setCreateBy($user);

        $form = $this->createForm(TankType::class, $tank)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createTank->execute($tank);
            $this->addFlash('success', "Cuve créée avec succès");

            return $this->redirectToRoute("index");
        }

        return $this->render("ui/tank/create.html.twig", [
            "entity" => $tank,
            "form" => $form->createView()
        ]);
    }
}
