<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\CompanyFamilyRepository;
use App\Adapter\InMemory\Repository\CompanyRepository;
use App\Entity\CompanyFamily;
use App\Entity\Company;
use App\Entity\TypeCompany;
use App\UseCase\UseCompany;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateCompanyTest
 * @package App\Tests\Unit
 */
class CreateCompanyTest extends TestCase
{
    public function testSuccessfulCompanyCreated()
    {
        $useCase = new UseCompany(new CompanyRepository());

        $typecompany = (new TypeCompany())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        $companyfamily = (new CompanyFamily($typecompany))
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        $company = (new Company($companyfamily))
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        $this->AssertEquals($company, $useCase->create($company));
    }
    /**
     * @dataProvider provideBadCompany
     * @param Company $company
     */
    public function testBadCompany(Company $company)
    {
        $useCase = new UseCompany(new CompanyRepository());

        $this->expectException(LazyAssertionException::class);

        $this->assertEquals($company, $useCase->create($company));
    }

    /**
     * @return \Generator
     */
    public function provideBadCompany(): \Generator
    {
        $typecompany = (new TypeCompany())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        $companyfamily = (new CompanyFamily($typecompany))
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        yield [
            (new Company($companyfamily))
                ->setName("name")
                ->setDescription("description")
        ];
        yield [
            (new Company($companyfamily))
                ->setCode("")
                ->setName("name")
                ->setDescription("description")
        ];
        yield [
            (new Company($companyfamily))
                ->setName("name")
                ->setDescription("description")
        ];
        yield [
            (new Company($companyfamily))
                ->setCode("code")
                ->setName("")
                ->setDescription("description")
        ];
        yield [
            (new Company($companyfamily))
                ->setCode("code")
                ->setName("name")
        ];
        yield [
            (new Company($companyfamily))
                ->setName("code")
                ->setName("name")
                ->setDescription("")
        ];
    }
}
