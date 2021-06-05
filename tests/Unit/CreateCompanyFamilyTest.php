<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeCompanyRepository;
use App\Adapter\InMemory\Repository\CompanyFamilyRepository;
use App\Entity\TypeCompany;
use App\Entity\CompanyFamily;
use App\UseCase\UseCompanyFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateCompanyFamilyTest
 * @package App\Tests\Unit
 */
class CreateCompanyFamilyTest extends TestCase
{
    public function testSuccessfulCompanyFamilyCreated()
    {
        $useCase = new UseCompanyFamily(new CompanyFamilyRepository());

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

        $this->AssertEquals($companyfamily, $useCase->create($companyfamily));
    }
    /**
     * @dataProvider provideBadCompanyFamily
     * @param CompanyFamily $companyfamily
     */
    public function testBadCompanyFamily(CompanyFamily $companyfamily)
    {
        $useCase = new UseCompanyFamily(new CompanyFamilyRepository());

        $this->expectException(LazyAssertionException::class);

        $this->assertEquals($companyfamily, $useCase->create($companyfamily));
    }

    /**
     * @return \Generator
     */
    public function provideBadCompanyFamily(): \Generator
    {
        $typecompany = (new TypeCompany())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        yield [
            (new CompanyFamily($typecompany))
                ->setName("name")
                ->setDescription("description")
        ];
        yield [
            (new CompanyFamily($typecompany))
                ->setCode("")
                ->setName("name")
                ->setDescription("description")
        ];
        yield [
            (new CompanyFamily($typecompany))
                ->setName("name")
                ->setDescription("description")
        ];
        yield [
            (new CompanyFamily($typecompany))
                ->setCode("code")
                ->setName("")
                ->setDescription("description")
        ];
        yield [
            (new CompanyFamily($typecompany))
                ->setCode("code")
                ->setName("name")
        ];
        yield [
            (new CompanyFamily($typecompany))
                ->setName("code")
                ->setName("name")
                ->setDescription("")
        ];
    }
}
