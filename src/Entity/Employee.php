<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Employee
 * @package App\Entity
 * @ORM\Entity
 */
class Employee extends User
{
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ["ROLE_USER","ROLE_EMPLOYEE"];
    }
}
