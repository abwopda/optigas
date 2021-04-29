<?php


namespace App\UseCase;

use App\Entity\Employee;
use App\Gateway\EmployeeGateway;
use Assert\Assert;

/**
 * Class RegisterEmployee
 * @package App\UseCase
 */
class RegisterEmployee
{
    /**
     * @var EmployeeGateway
     */
    private EmployeeGateway $employeeGateway;

    /**
     * RegisterEmployee constructor.
     * @param EmployeeGateway $employeeGateway
     */
    public function __construct(EmployeeGateway $employeeGateway)
    {
        $this->employeeGateway = $employeeGateway;
    }

    /**
     * @param Employee $employee
     * @return Employee
     */
    public  function execute(Employee $employee) : Employee
    {
        //var_export($employee);
        Assert::lazy()
            ->that($employee->getFirstName(),"firstName")->notBlank()
            ->that($employee->getLastName(),"lastName")->notBlank()
            ->that($employee->getPlainPassword(),"plainPassword")
                ->notBlank()
                ->regex(
                    "/^(?:(?=.*[a-z])(?:(?=.*[A-Z])(?=.*[\d\W])|(?=.*\W)(?=.*\d))|(?=.*\W)(?=.*[A-Z])(?=.*\d)).{8,}$/"
                )
            ->that($employee->getEmail(),"email")
                ->notBlank()
                ->email()
            ->verifyNow()
        ;

        $this->employeeGateway->register($employee);

        return $employee;
    }
}