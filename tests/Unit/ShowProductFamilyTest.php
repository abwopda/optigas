<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductFamilyRepository;
use App\Entity\ProductFamily;
use App\UseCase\showProductFamily;
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
        $useCase = new showProductFamily(new ProductFamilyRepository());

        $this->assertInstanceOf(ProductFamily::class, $useCase->execute(1));
    }

    /**
     * @dataProvider provideBadProductFamily
     * @param int $productfamily
     */
    public function testBadProductFamily(int $productfamily)
    {
        $useCase = new showProductFamily(new ProductFamilyRepository());

        $this->assertNull($useCase->execute($productfamily));
    }

    /**
     * @return \Generator
     */
    public function provideBadProductFamily(): \Generator
    {
        yield [
            10
        ];
    }
}
