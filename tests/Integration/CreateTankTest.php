<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\TankRepository;
use App\Entity\Pos;
use App\Entity\Tank;
use App\UseCase\CreateTank;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CreateTankTest
 * @package App\Tests\Integration
 */
class CreateTankTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulTankCreated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("tank.create", ["pos" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "tank[code]" => "CUV0000",
            "tank[name]" => "Super 1",
            "tank[description]" => "Tawaal Oil AKAK",
            "tank[capacity]" => 30000
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
            $router->generate("tank.new", ["pos" => 1])
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
            "tank[name]" => "Super 1",
            "tank[description]" => "Tawaal Oil AKAK",
            "tank[capacity]" => 30000
        ]];

        yield[[
            "tank[code]" => "",
            "tank[name]" => "Super 1",
            "tank[description]" => "Tawaal Oil AKAK",
            "tank[capacity]" => 30000
        ]];

        yield[[
            "tank[code]" => "CUV0000",
            "tank[description]" => "Tawaal Oil AKAK",
            "tank[capacity]" => 30000
        ]];

        yield[[
            "tank[code]" => "CUV0000",
            "tank[name]" => "",
            "tank[description]" => "Tawaal Oil AKAK",
            "tank[capacity]" => 30000
        ]];

        yield[[
            "tank[code]" => "CUV0000",
            "tank[name]" => "Super 1",
            "tank[capacity]" => 30000
        ]];

        yield[[
            "tank[code]" => "CUV0000",
            "tank[name]" => "Super 1",
            "tank[description]" => "",
            "tank[capacity]" => 30000
        ]];

        yield[[
            "tank[code]" => "CUV0000",
            "tank[name]" => "Super 1",
            "tank[description]" => "Tawaal Oil AKAK",
        ]];
    }
}
