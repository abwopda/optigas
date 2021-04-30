<?php

namespace App\Gateway;

use App\Entity\Employee;

/**
 * Interface EmployeeGateway
 * @package App\Gateway
 */
interface EmployeeGateway extends UserGateway
{
    /**
     * @param Employee $employee
     */
    public function register(Employee $employee): void;
}
