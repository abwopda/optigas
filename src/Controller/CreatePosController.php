<?php

namespace App\Controller;

use App\Entity\Pos;
use App\Form\PosType;
use App\UseCase\CreatePos;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

/**
 * Class CreatePosController
 * @package App\Controller
 */
class CreatePosController
{
    private FormFactoryInterface $formFactory;
    private CreatePos $createPos;
    private UrlGeneratorInterface $urlGenerator;
    private Environment $twig;
    private Security $security;

    /**
     * CreatePosController constructor.
     * @param FormFactoryInterface $formfactory
     * @param CreatePos $createPos
     * @param UrlGeneratorInterface $urlGenerator
     * @param Environment $twig
     * @param Security $security
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        CreatePos $createPos,
        UrlGeneratorInterface $urlGenerator,
        Environment $twig,
        Security $security
    ) {
        $this->formFactory = $formFactory;
        $this->posCreate = $createPos;
        $this->urlGenerator = $urlGenerator;
        $this->twig = $twig;
        $this->security = $security;
    }


    /**
     * @param Request $request
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(Request $request): Response
    {
        $pos = new Pos();

        $pos->setCreateBy($this->security->getUser());

        $form = $this->formFactory->create(PosType::class, $pos)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->posCreate->execute($pos);

            return new RedirectResponse($this->urlGenerator->generate("index"));
        }

        return new Response($this->twig->render("ui/create_pos.html.twig", [
            "form" => $form->createView()
        ]));
    }
}
