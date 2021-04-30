<?php

namespace App\Features;

use App\Adapter\InMemory\Repository\EmployeeRepository;
use App\Entity\Employee;
use App\UseCase\RegisterEmployee;
use Assert\Assertion;
use Behat\Behat\Context\Context;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class RegisterEmployeeContext
 * @package App\Features
 */
class RegisterEmployeeContext implements Context
{
    /**
     * @var RegisterEmployee
     */
    private RegisterEmployee $registerEmployee;

    /**
     * @var Employee
     */
    private Employee $employee;
    /**
     * @Given /^an employee need to be registered before using the platform$/
     */
    public function anEmployeeNeedToBeRegisteredBeforeUsingThePlatform()
    {
        $userPasswordEncoder = new class () implements UserPasswordEncoderInterface
        {
            /**
             * @inheritDoc
             */
            public function encodePassword(UserInterface $user, string $plainPassword)
            {
                return "hash_password";
            }

            public function isPasswordValid(UserInterface $user, string $raw)
            {
            }

            public function needsRehash(UserInterface $user): bool
            {
            }
        };
        $this->registerEmployee = new RegisterEmployee(
            new EmployeeRepository($userPasswordEncoder),
            $userPasswordEncoder
        );
    }

    /**
     * @Then /^the employee can log in with the account created$/
     */
    public function theEmployeeCanLogInWithTheAccountCreated()
    {
        Assertion::eq($this->employee, $this->registerEmployee->execute($this->employee));
    }

    /**
     * @When an administrator fill the registration form
     */
    public function anAdministratorFillTheRegistrationForm()
    {
        $this->employee = new Employee();
        $this->employee->setPlainPassword("Password123!");
        $this->employee->setEmail("email@email.com");
        $this->employee->setFirstName("John");
        $this->employee->setLastName("Doe");
    }
}
