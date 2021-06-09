<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\StoreRepository;
use App\Entity\Store;
use App\UseCase\UseStore;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateStoreTest
 * @package App\Tests\Unit
 */
class UpdateStoreTest extends TestCase
{
    public function testSuccessfulStoreUpdated()
    {
        $useCase = new UseStore(new StoreRepository());
        for ($i = 3; $i <= 3; $i++) {
            $store = (new StoreRepository())
                ->findOneById($i)
                ->setName("PCCC " . $i)
            ;

            $this->assertInstanceOf(Store::class, $useCase->update($store));
        }
    }
}
