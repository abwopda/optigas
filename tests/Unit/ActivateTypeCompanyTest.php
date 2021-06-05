<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeCompanyRepository;
use App\Entity\TypeCompany;
use App\UseCase\UseTypeCompany;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivateTypeCompanyTest
 * @package App\Tests\Unit
 */
class ActivateTypeCompanyTest extends TestCase
{
    public function testSuccessfulTypeCompanyActivated()
    {
        $useCase = new UseTypeCompany(new TypeCompanyRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new TypeCompanyRepository())->findOneById($i);

            $this->assertInstanceOf(TypeCompany::class, $useCase->activate($entity, true));

            $this->assertInstanceOf(TypeCompany::class, $useCase->activate($entity, false));
        }
    }
}
