<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeCompanyRepository;
use App\Entity\TypeCompany;
use App\UseCase\UseTypeCompany;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateTypeCompanyTest
 * @package App\Tests\Unit
 */
class UpdateTypeCompanyTest extends TestCase
{
    public function testSuccessfulTypeCompanyUpdated()
    {
        $useCase = new UseTypeCompany(new TypeCompanyRepository());

        for ($i = 3; $i <= 3; $i++) {
            $entity = (new TypeCompanyRepository())
                ->findOneById($i)
                ->setName("TYP0" . $i)
            ;
            $this->assertInstanceOf(TypeCompany::class, $useCase->update($entity));
        }
    }
}
