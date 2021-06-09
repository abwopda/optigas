<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\StoreRepository;
use App\Entity\Store;
use App\UseCase\UseStore;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ShowStoreTest
 * @package App\Tests\Unit
 */
class ShowStoreTest extends TestCase
{
    public function testSuccessfulStoreShowed()
    {
        $useCase = new UseStore(new StoreRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new StoreRepository())->findOneById($i);
            $this->assertInstanceOf(Store::class, $useCase->show($entity));
        }
    }

    /**
     * @dataProvider provideBadStore
     * @param Store|null $pos
     */
    public function testBadStore(?Store $pos)
    {
        $useCase = new UseStore(new StoreRepository());

        $this->assertNull($useCase->show($pos));
    }

    /**
     * @return \Generator
     */
    public function provideBadStore(): \Generator
    {
        yield [
            (new StoreRepository())->findOneById(5)
        ];
    }
}
