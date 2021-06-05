<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeCompanyRepository;
use App\Entity\TypeCompany;
use App\UseCase\UseTypeCompany;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidateTypeCompanyTest
 * @package App\Tests\Unit
 */
class ValidateTypeCompanyTest extends TestCase
{
    public function testSuccessfulTypeCompanyValidated()
    {
        $useCase = new UseTypeCompany(new TypeCompanyRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new TypeCompanyRepository())->findOneById($i);

            $this->assertInstanceOf(TypeCompany::class, $useCase->validate($entity, true));

            $this->assertInstanceOf(TypeCompany::class, $useCase->validate($entity, false));
        }
    }
}
