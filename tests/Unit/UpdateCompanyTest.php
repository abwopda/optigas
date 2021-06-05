<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\CompanyRepository;
use App\Entity\Company;
use App\UseCase\UseCompany;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateCompanyTest
 * @package App\Tests\Unit
 */
class UpdateCompanyTest extends TestCase
{
    public function testSuccessfulCompanyUpdated()
    {
        $useCase = new UseCompany(new CompanyRepository());

        for ($i = 7; $i <= 7; $i++) {
            $entity = (new CompanyRepository())
                ->findOneById($i)
                ->setName("PROD0" . $i)
            ;
            $this->assertInstanceOf(Company::class, $useCase->update($entity));
        }
    }
}
