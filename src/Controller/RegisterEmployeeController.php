<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeRegistrationType;
use App\UseCase\RegisterEmployee;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Class RegisterEmployeeController
 * @package App\Controller
 */
class RegisterEmployeeController
{
    private FormFactoryInterface $formfactory;
    private RegisterEmployee $employeeRegister;
    private UrlGeneratorInterface $urlGenerator;
    private Environment $twig;

    /**
     * RegisterEmployeeController constructor.
     * @param FormFactoryInterface $formfactory
     * @param RegisterEmployee $employeeRegister
     * @param UrlGeneratorInterface $urlGenerator
     * @param Environment $twig
     */
    public function __construct(
        FormFactoryInterface $formfactory,
        RegisterEmployee $employeeRegister,
        UrlGeneratorInterface $urlGenerator,
        Environment $twig
    ) {
        $this->formfactory = $formfactory;
        $this->employeeRegister = $employeeRegister;
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
        $employee = new Employee();

        $form = $this->formfactory->create(EmployeeRegistrationType::class, $employee)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->employeeRegister->execute($employee);

            return new RedirectResponse($this->urlGenerator->generate("index"));
        }

        return new Response($this->twig->render("ui/register_employee.html.twig", [
            "form" => $form->createView()
        ]));
    }
}
