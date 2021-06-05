<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeCompanyRepository;
use App\Entity\TypeCompany;
use App\UseCase\UseTypeCompany;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateTypeCompanyTest
 * @package App\Tests\Unit
 */
class CreateTypeCompanyTest extends TestCase
{
    public function testSuccessfulTypeCompanyCreated()
    {
        $useCase = new UseTypeCompany(new TypeCompanyRepository());

        $typecompany = (new TypeCompany())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        $this->AssertEquals($typecompany, $useCase->create($typecompany));
    }
    /**
     * @dataProvider provideBadTypeCompany
     * @param TypeCompany $typecompany
     */
    public function testBadTypeCompany(TypeCompany $typecompany)
    {
        $useCase = new UseTypeCompany(new TypeCompanyRepository());

        $this->expectException(LazyAssertionException::class);

        $this->assertEquals($typecompany, $useCase->create($typecompany));
    }

    /**
     * @return \Generator
     */
    public function provideBadTypeCompany(): \Generator
    {
        yield[
            (new TypeCompany())
                ->setName("name")
                ->setDescription("description")
        ];
        yield[
            (new TypeCompany())
                ->setCode("")
                ->setName("name")
                ->setDescription("description")
        ];
        yield[
            (new TypeCompany())
                ->setCode("code")
                ->setDescription("description")
        ];
        yield[
            (new TypeCompany())
                ->setCode("code")
                ->setName("")
        ];
        yield[
            (new TypeCompany())
                ->setCode("code")
                ->setName("name")
                ->setDescription("")
        ];
    }
}
