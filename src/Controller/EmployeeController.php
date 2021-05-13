<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeRegistrationType;
use App\UseCase\RegisterEmployee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Class EmployeeController
 * @package App\Controller
 */
class EmployeeController extends AbstractController
{
    private RegisterEmployee $employeeRegister;

    /**
     * EmployeeController constructor.
     * @param RegisterEmployee $employeeRegister
     */
    public function __construct(
        RegisterEmployee $employeeRegister
    ) {
        $this->employeeRegister = $employeeRegister;
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
        $employee = new Employee();

        $form = $this->createForm(EmployeeRegistrationType::class, $employee)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->employeeRegister->execute($employee);

            return $this->redirectToRoute("index");
        }

        return $this->render("ui/register_employee.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
