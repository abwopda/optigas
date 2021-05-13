<?php

namespace App\Controller;

use App\Entity\Tank;
use App\Entity\Pump;
use App\Form\PumpType;
use App\Gateway\TankGateway;
use App\UseCase\CreatePump;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

/**
 * Class CreatePumpController
 * @package App\Controller
 */
class CreatePumpController
{
    private FormFactoryInterface $formFactory;
    private CreatePump $createPump;
    private UrlGeneratorInterface $urlGenerator;
    private Environment $twig;
    private Security $security;
    private TankGateway $posGateway;

    /**
     * CreatePumpController constructor.
     * @param FormFactoryInterface $formfactory
     * @param CreatePump $createPump
     * @param UrlGeneratorInterface $urlGenerator
     * @param Environment $twig
     * @param Security $security
     * @param TankGateway $posGateway
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        CreatePump $createPump,
        UrlGeneratorInterface $urlGenerator,
        Environment $twig,
        Security $security,
        TankGateway $posGateway
    ) {
        $this->formFactory = $formFactory;
        $this->createPump = $createPump;
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
    public function __invoke(int $tank, Request $request): Response
    {
        $pump = new Pump($this->posGateway->findOneById($tank));

        $pump->setCreateBy($this->security->getUser());

        $form = $this->formFactory->create(PumpType::class, $pump)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createPump->execute($pump);

            return new RedirectResponse($this->urlGenerator->generate("index"));
        }

        return new Response($this->twig->render("ui/pump/create.html.twig", [
            "entity" => $pump,
            "form" => $form->createView()
        ]));
    }
}
