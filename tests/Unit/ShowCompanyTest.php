<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\CompanyRepository;
use App\Entity\Company;
use App\UseCase\UseCompany;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ShowCompanyTest
 * @package App\Tests\Unit
 */
class ShowCompanyTest extends TestCase
{
    public function testSuccessfulCompanyShowed()
    {
        $useCase = new UseCompany(new CompanyRepository());

        for ($i = 7; $i <= 7; $i++) {
            $entity = (new CompanyRepository())->findOneById($i);
            $this->assertInstanceOf(Company::class, $useCase->show($entity));
        }
    }

    /**
     * @dataProvider provideBadCompany
     * @param Company|null $company
     */
    public function testBadCompany(?Company $company)
    {
        $useCase = new UseCompany(new CompanyRepository());

        $this->assertNull($useCase->show($company));
    }

    /**
     * @return \Generator
     */
    public function provideBadCompany(): \Generator
    {
        yield [
            (new CompanyRepository())->findOneById(20)
        ];
    }
}
