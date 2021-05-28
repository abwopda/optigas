<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ConfigRepository;
use App\Entity\Config;
use App\UseCase\ShowConfig;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ShowConfigTest
 * @package App\Tests\Unit
 */
class ShowConfigTest extends TestCase
{
    public function testSuccessfulConfigShowed()
    {
        $useCase = new ShowConfig(new ConfigRepository());

        $entity = (new ConfigRepository())->findOneById(1);
        $this->assertInstanceOf(Config::class, $useCase->execute($entity));
    }

    /**
     * @dataProvider provideBadConfig
     * @param Config|null $config
     */
    public function testBadConfig(?Config $config)
    {
        $useCase = new showConfig(new ConfigRepository());

        $this->assertNull($useCase->execute($config));
    }

    /**
     * @return \Generator
     */
    public function provideBadConfig(): \Generator
    {
        yield [
            (new ConfigRepository())->findOneById(20)
        ];
    }
}
