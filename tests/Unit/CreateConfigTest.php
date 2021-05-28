<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ConfigRepository;
use App\Entity\Config;
use App\UseCase\CreateConfig;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateConfigTest
 * @package App\Tests\Unit
 */
class CreateConfigTest extends TestCase
{
    public function testSuccessfulConfigCreated()
    {
        $useCase = new createConfig(new ConfigRepository());

        $config = (new Config())
            ->setTheKey("thekey")
            ->setTheValue("thevalue")
        ;

        $this->AssertEquals($config, $useCase->execute($config));
    }
    /**
     * @dataProvider provideBadConfig
     * @param Config $config
     */
    public function testBadConfig(Config $config)
    {
        $useCase = new CreateConfig(new ConfigRepository());

        $this->expectException(LazyAssertionException::class);

        $this->assertEquals($config, $useCase->execute($config));
    }

    /**
     * @return \Generator
     */
    public function provideBadConfig(): \Generator
    {
        yield[
            (new Config())
                ->setTheValue("thevalue")
        ];
        yield[
            (new Config())
                ->setTheKey("")
                ->setTheValue("thevalue")
        ];
        yield[
            (new Config())
                ->setTheKey("thekey")
        ];
        yield[
            (new Config())
                ->setTheKey("thekey")
                ->setTheValue("")
        ];
    }
}
