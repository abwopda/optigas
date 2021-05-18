<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\PumpRepository;
use App\Entity\Pump;
use App\UseCase\UpdatePump;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class UpdatePumpTest
 * @package App\Tests\Integration
 */
class UpdatePumpTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulPumpUpdated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("pump.edit", ["id" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "pump[code]" => "P00",
            "pump[name]" => "Super 1",
            "pump[description]" => "Station service ZZZ",
            "pump[counter]" => 512365788,
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
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
            $router->generate("pump.edit", ["id" => 1])
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
            "pump[code]" => "",
            "pump[name]" => "Super 1",
            "pump[description]" => "Station service ZZZ",
            "pump[counter]" => 512365788,
        ]];
        yield[[
            "pump[code]" => "P00",
            "pump[name]" => "",
            "pump[description]" => "Station service ZZZ",
            "pump[counter]" => 512365788,
        ]];
        yield[[
            "pump[code]" => "P00",
            "pump[name]" => "Super 1",
            "pump[description]" => "",
            "pump[counter]" => 512365788,
        ]];
    }
}
