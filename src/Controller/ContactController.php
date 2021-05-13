<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactRegistrationType;
use App\UseCase\RegisterContact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Class ContactController
 * @package App\Controller
 */
class ContactController extends AbstractController
{
    private RegisterContact $contactRegister;

    /**
     * ContactController constructor.
     * @param RegisterContact $contactRegister
     */
    public function __construct(
        RegisterContact $contactRegister
    ) {
        $this->contactRegister = $contactRegister;
    }


    /**
     * @param Request $request
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError

     */
    public function register(Request $request): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactRegistrationType::class, $contact)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactRegister->execute($contact);

            return $this->redirectToRoute("index");
        }

        return $this->render("ui/register_contact.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
