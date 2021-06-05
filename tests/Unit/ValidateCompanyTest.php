<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\CompanyRepository;
use App\Entity\Company;
use App\UseCase\UseCompany;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidateCompanyTest
 * @package App\Tests\Unit
 */
class ValidateCompanyTest extends TestCase
{
    public function testSuccessfulCompanyValidated()
    {
        $useCase = new UseCompany(new CompanyRepository());
        for ($i = 7; $i <= 7; $i++) {
            $entity = (new CompanyRepository())->findOneById($i);

            $this->assertInstanceOf(Company::class, $useCase->validate($entity, true));

            $this->assertInstanceOf(Company::class, $useCase->validate($entity, false));
        }
    }
}
