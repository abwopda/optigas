<?php

namespace App\Controller;

use App\Entity\Pos;
use App\Entity\Tank;
use App\Form\TankType;
use App\Gateway\PosGateway;
use App\UseCase\CreateTank;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

/**
 * Class CreateTankController
 * @package App\Controller
 */
class CreateTankController
{
    private FormFactoryInterface $formFactory;
    private CreateTank $createTank;
    private UrlGeneratorInterface $urlGenerator;
    private Environment $twig;
    private Security $security;
    private PosGateway $posGateway;

    /**
     * CreateTankController constructor.
     * @param FormFactoryInterface $formfactory
     * @param CreateTank $createTank
     * @param UrlGeneratorInterface $urlGenerator
     * @param Environment $twig
     * @param Security $security
     * @param PosGateway $posGateway
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        CreateTank $createTank,
        UrlGeneratorInterface $urlGenerator,
        Environment $twig,
        Security $security,
        PosGateway $posGateway
    ) {
        $this->formFactory = $formFactory;
        $this->createTank = $createTank;
        $this->urlGenerator = $urlGenerator;
        $this->twig = $twig;
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
    public function __invoke(int $pos, Request $request): Response
    {
        $tank = new Tank($this->posGateway->findOneById($pos));

        $tank->setCreateBy($this->security->getUser());

        $form = $this->formFactory->create(TankType::class, $tank)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createTank->execute($tank);

            return new RedirectResponse($this->urlGenerator->generate("index"));
        }

        return new Response($this->twig->render("ui/tank/create.html.twig", [
            "entity" => $tank,
            "form" => $form->createView()
        ]));
    }
}
