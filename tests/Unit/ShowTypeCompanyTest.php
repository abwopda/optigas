<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeCompanyRepository;
use App\Entity\TypeCompany;
use App\UseCase\UseTypeCompany;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateTypeCompanyTest
 * @package App\Tests\Unit
 */
class ShowTypeCompanyTest extends TestCase
{
    public function testSuccessfulTypeCompanyShowed()
    {
        $useCase = new UseTypeCompany(new TypeCompanyRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new TypeCompanyRepository())->findOneById($i);
            $this->assertInstanceOf(TypeCompany::class, $useCase->show($entity));
        }
    }

    /**
     * @dataProvider provideBadTypeCompany
     * @param TypeCompany|null $typecompany
     */
    public function testBadTypeCompany(?TypeCompany $typecompany)
    {
        $useCase = new UseTypeCompany(new TypeCompanyRepository());

        $this->assertNull($useCase->show($typecompany));
    }

    /**
     * @return \Generator
     */
    public function provideBadTypeCompany(): \Generator
    {
        yield [
            (new TypeCompanyRepository())->findOneById(5)
        ];
    }
}
