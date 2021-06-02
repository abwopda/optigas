<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductFamilyRepository;
use App\Entity\ProductFamily;
use App\UseCase\UseProductFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ShowProductFamilyTest
 * @package App\Tests\Unit
 */
class ShowProductFamilyTest extends TestCase
{
    public function testSuccessfulProductFamilyShowed()
    {
        $useCase = new UseProductFamily(new ProductFamilyRepository());
        for ($i = 5; $i <= 5; $i++) {
            $entity = (new ProductFamilyRepository())->findOneById($i);
            $this->assertInstanceOf(ProductFamily::class, $useCase->show($entity));
        }
    }

    /**
     * @dataProvider provideBadProductFamily
     * @param ProductFamily|null $productfamily
     */
    public function testBadProductFamily(?ProductFamily $productfamily)
    {
        $useCase = new UseProductFamily(new ProductFamilyRepository());

        $this->assertNull($useCase->show($productfamily));
    }

    /**
     * @return \Generator
     */
    public function provideBadProductFamily(): \Generator
    {
        yield [
            (new ProductFamilyRepository())->findOneById(10)
        ];
    }
}
