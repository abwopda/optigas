<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pos;
use App\Entity\Pump;
use App\UseCase\CreatePump;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CreatePumpTest
 * @package App\Tests\Integration
 */
class CreatePumpTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulPumpCreated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("pump.create", ["tank" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "pump[code]" => "POM0000",
            "pump[name]" => "Super 1",
            "pump[description]" => "Tawaal Oil AKAK",
            "pump[counter]" => 4578952
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }


    /**
     * @dataProvider provideBadRequest
     * @param array $formData
     */
    public function testBadRequest(array $formData)
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("pump.create", ["tank" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form($formData);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @return \Generator
     */
    public function provideBadRequest(): \Generator
    {
        yield[[
            "pump[name]" => "Super 1",
            "pump[description]" => "Tawaal Oil AKAK",
            "pump[counter]" => 4578952
        ]];

        yield[[
            "pump[code]" => "",
            "pump[name]" => "Super 1",
            "pump[description]" => "Tawaal Oil AKAK",
            "pump[counter]" => 4578952
        ]];

        yield[[
            "pump[code]" => "POM0000",
            "pump[description]" => "Tawaal Oil AKAK",
            "pump[counter]" => 4578952
        ]];

        yield[[
            "pump[code]" => "POM0000",
            "pump[name]" => "",
            "pump[description]" => "Tawaal Oil AKAK",
            "pump[counter]" => 4578952
        ]];

        yield[[
            "pump[code]" => "POM0000",
            "pump[name]" => "Super 1",
            "pump[counter]" => 4578952
        ]];

        yield[[
            "pump[code]" => "POM0000",
            "pump[name]" => "Super 1",
            "pump[description]" => "",
            "pump[counter]" => 4578952
        ]];

        yield[[
            "pump[code]" => "POM0000",
            "pump[name]" => "Super 1",
            "pump[description]" => "Tawaal Oil AKAK",
        ]];
    }
}
