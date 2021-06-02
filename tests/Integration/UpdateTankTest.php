<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Tank;
use App\UseCase\UseTank;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class UpdateTankTest
 * @package App\Tests\Integration
 */
class UpdateTankTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulTankUpdated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("tank.edit", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("tank.update", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 4; $i <= 4; $i++) {
            $crawler = $client->request(
                Request::METHOD_GET,
                $router->generate("tank.edit", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_OK);

            $form = $crawler->filter("form")->form([
                "tank[code]" => "CUV00" . $i,
                "tank[name]" => "Super Gasoil" . $i,
                "tank[description]" => "Station service ZZZ" . $i,
                "tank[capacity]" => 10000,
            ]);

            $client->submit($form);

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        }
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
            $router->generate("tank.edit", ["id" => 1])
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
            "tank[code]" => "",
            "tank[name]" => "Super Gasoil",
            "tank[description]" => "Station service ZZZ",
            "tank[capacity]" => 10000,
        ]];
        yield[[
            "tank[code]" => "CUV00",
            "tank[name]" => "",
            "tank[description]" => "Station service ZZZ",
            "tank[capacity]" => 10000,
        ]];
        yield[[
            "tank[code]" => "CUV00",
            "tank[name]" => "Super Gasoil",
            "tank[description]" => "",
            "tank[capacity]" => 10000,
        ]];
    }
}
