<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactRegistrationType;
use App\UseCase\RegisterContact;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Class RegisterContactController
 * @package App\Controller
 */
class RegisterContactController
{
    private FormFactoryInterface $formfactory;
    private RegisterContact $contactRegister;
    private UrlGeneratorInterface $urlGenerator;
    private Environment $twig;

    /**
     * RegisterContactController constructor.
     * @param FormFactoryInterface $formfactory
     * @param RegisterContact $contactRegister
     * @param UrlGeneratorInterface $urlGenerator
     * @param Environment $twig
     */
    public function __construct(
        FormFactoryInterface $formfactory,
        RegisterContact $contactRegister,
        UrlGeneratorInterface $urlGenerator,
        Environment $twig
    ) {
        $this->formfactory = $formfactory;
        $this->contactRegister = $contactRegister;
        $this->urlGenerator = $urlGenerator;
        $this->twig = $twig;
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
        $contact = new Contact();

        $form = $this->formfactory->create(ContactRegistrationType::class, $contact)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactRegister->execute($contact);

            return new RedirectResponse($this->urlGenerator->generate("index"));
        }

        return new Response($this->twig->render("ui/register_contact.html.twig", [
            "form" => $form->createView()
        ]));
    }
}
