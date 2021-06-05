<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeCompanyRepository;
use App\Entity\TypeCompany;
use App\UseCase\UseTypeCompany;
use PHPUnit\Framework\TestCase;

/**
 * Class DeleteTypeCompanyTest
 * @package App\Tests\Unit
 */
class DeleteTypeCompanyTest extends TestCase
{
    public function testSuccessfulTypeCompanyDeleted()
    {
        $useCase = new UseTypeCompany(new TypeCompanyRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new TypeCompanyRepository())->findOneById($i);

            $this->assertNull($useCase->delete($entity));
        }
    }
}
