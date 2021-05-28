<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ConfigRepository;
use App\Entity\Config;
use App\UseCase\IndexConfig;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexConfigTest
 * @package App\Tests\Unit
 */
class IndexConfigTest extends TestCase
{
    public function testSuccessfulConfigIndexed()
    {
        $useCase = new IndexConfig(new ConfigRepository());
        $this->assertContainsOnlyInstancesOf(Config::class, $useCase->execute());
    }
}
