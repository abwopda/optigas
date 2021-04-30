<?php

namespace App\Adapter\Doctrine\Repository;

use App\Entity\Employee;
use App\Gateway\EmployeeGateway;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class EmployeeRepository
 * @package App\Adapter\Doctrine\Repository
 */
class EmployeeRepository extends UserRepository implements EmployeeGateway
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function register(Employee $employee): void
    {
        $this->_em->persist($employee);
        $this->_em->flush();
    }
}
