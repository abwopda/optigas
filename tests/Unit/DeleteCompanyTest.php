<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\CompanyRepository;
use App\Entity\Company;
use App\UseCase\UseCompany;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class DeleteCompanyTest
 * @package App\Tests\Unit
 */
class DeleteCompanyTest extends TestCase
{
    public function testSuccessfulCompanyDeleted()
    {
        $useCase = new UseCompany(new CompanyRepository());
        for ($i = 7; $i <= 7; $i++) {
            $entity = (new CompanyRepository())->findOneById($i);

            $this->assertNull($useCase->delete($entity));
        }
    }
}
