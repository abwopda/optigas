<?php

namespace App\Controller;

use App\Entity\Tank;
use App\Entity\Pump;
use App\Form\PumpType;
use App\Gateway\TankGateway;
use App\UseCase\CreatePump;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

/**
 * Class PumpController
 * @package App\Controller
 */
class PumpController extends AbstractController
{
    private CreatePump $createPump;
    private Security $security;
    private TankGateway $posGateway;

    /**
     * PumpController constructor.
     * @param CreatePump $createPump
     * @param Security $security
     * @param TankGateway $posGateway
     */
    public function __construct(
        CreatePump $createPump,
        Security $security,
        TankGateway $posGateway
    ) {
        $this->createPump = $createPump;
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
    public function create(int $tank, Request $request): Response
    {
        $pump = new Pump($this->posGateway->findOneById($tank));

        $user = $this->security->getUser();

        $pump->setCreateBy($user);

        $form = $this->createForm(PumpType::class, $pump)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createPump->execute($pump);
            $this->addFlash('success', "Pompe créée avec succès");

            return $this->redirectToRoute("index");
        }

        return $this->render("ui/pump/create.html.twig", [
            "entity" => $pump,
            "form" => $form->createView()
        ]);
    }
}
