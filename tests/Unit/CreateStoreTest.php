<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\StoreRepository;
use App\Entity\Store;
use App\UseCase\UseStore;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateStoreTest
 * @package App\Tests\Unit
 */
class CreateStoreTest extends TestCase
{
    public function testSuccessfulStoreCreated()
    {
        $useCase = new UseStore(new StoreRepository());

        $store = (new Store())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
            ->setTown("town")
            ->setAddress("address")
        ;

        $this->AssertEquals($store, $useCase->create($store));
    }
    /**
     * @dataProvider provideBadStore
     * @param Store $store
     */
    public function testBadStore(Store $store)
    {
        $useCase = new UseStore(new StoreRepository());

        $this->expectException(LazyAssertionException::class);

        $this->assertEquals($store, $useCase->create($store));
    }

    /**
     * @return \Generator
     */
    public function provideBadStore(): \Generator
    {
        yield[
            (new Store())
                ->setName("name")
                ->setDescription("description")
                ->setTown("town")
                ->setAddress("address")
        ];
        yield[
            (new Store())
                ->setCode("")
                ->setName("name")
                ->setDescription("description")
                ->setTown("town")
                ->setAddress("address")
        ];
        yield[
            (new Store())
                ->setCode("code")
                ->setDescription("description")
                ->setTown("town")
                ->setAddress("address")
        ];
        yield[
            (new Store())
                ->setCode("code")
                ->setName("")
                ->setTown("town")
                ->setAddress("address")
        ];
        yield[
            (new Store())
                ->setCode("code")
                ->setName("name")
                ->setDescription("")
                ->setTown("town")
                ->setAddress("address")
        ];
        yield[
            (new Store())
                ->setCode("code")
                ->setName("name")
                ->setDescription("description")
                ->setAddress("address")
        ];
        yield[
            (new Store())
                ->setCode("code")
                ->setName("name")
                ->setDescription("description")
                ->setTown("")
                ->setAddress("address")
        ];
        yield[
            (new Store())
                ->setCode("code")
                ->setName("name")
                ->setDescription("description")
                ->setTown("town")
        ];
        yield[
            (new Store())
                ->setCode("code")
                ->setName("name")
                ->setDescription("description")
                ->setTown("town")
                ->setAddress("")
        ];
    }
}
