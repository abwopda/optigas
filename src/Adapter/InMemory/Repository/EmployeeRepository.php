<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Employee;
use App\Gateway\EmployeeGateway;

/**
 * Class EmployeeRepository
 * @package App\Adapter\InMemory\Repository
 */
class EmployeeRepository  implements EmployeeGateway
{
    public function register(Employee $employee): void
    {
        // TODO: Implement register() method.
    }

}
