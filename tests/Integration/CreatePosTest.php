<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\CreatePos;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CreatePosTest
 * @package App\Tests\Integration
 */
class CreatePosTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulPosCreated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("pos.new")
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "pos[code]" => "STA00",
            "pos[name]" => "Tawaal Oil AKAK",
            "pos[description]" => "Station service",
            "pos[town]" => "Yaoundé",
            "pos[address]" => "BP 10075",
            "pos[capacity]" => 95000,
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
            $router->generate("pos.create")
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
            "pos[name]" => "Tawaal Oil AKAK",
            "pos[description]" => "Station service",
            "pos[town]" => "Yaoundé",
            "pos[address]" => "BP 10075",
            "pos[capacity]" => 95000,
        ]];

        yield[[
            "pos[code]" => "",
            "pos[name]" => "Tawaal Oil AKAK",
            "pos[description]" => "Station service",
            "pos[town]" => "Yaoundé",
            "pos[address]" => "BP 10075",
            "pos[capacity]" => 95000,
        ]];

        yield[[
            "pos[code]" => "STA00",
            "pos[description]" => "Station service",
            "pos[town]" => "Yaoundé",
            "pos[address]" => "BP 10075",
            "pos[capacity]" => 95000,
        ]];

        yield[[
            "pos[code]" => "STA00",
            "pos[name]" => "",
            "pos[description]" => "Station service",
            "pos[town]" => "Yaoundé",
            "pos[address]" => "BP 10075",
            "pos[capacity]" => 95000,
        ]];

        yield[[
            "pos[code]" => "STA00",
            "pos[name]" => "Tawaal Oil AKAK",
            "pos[town]" => "Yaoundé",
            "pos[address]" => "BP 10075",
            "pos[capacity]" => 95000,
        ]];

        yield[[
            "pos[code]" => "STA00",
            "pos[name]" => "Tawaal Oil AKAK",
            "pos[description]" => "",
            "pos[town]" => "Yaoundé",
            "pos[address]" => "BP 10075",
            "pos[capacity]" => 95000,
        ]];

        yield[[
            "pos[code]" => "STA00",
            "pos[name]" => "Tawaal Oil AKAK",
            "pos[description]" => "Station service",
            "pos[address]" => "BP 10075",
            "pos[capacity]" => 95000,
        ]];

        yield[[
            "pos[code]" => "STA00",
            "pos[name]" => "Tawaal Oil AKAK",
            "pos[description]" => "Station service",
            "pos[town]" => "",
            "pos[address]" => "BP 10075",
            "pos[capacity]" => 95000,
        ]];

        yield[[
            "pos[code]" => "STA00",
            "pos[name]" => "Tawaal Oil AKAK",
            "pos[description]" => "Station service",
            "pos[town]" => "Yaoundé",
            "pos[capacity]" => 95000,
        ]];

        yield[[
            "pos[code]" => "STA00",
            "pos[name]" => "Tawaal Oil AKAK",
            "pos[description]" => "Station service",
            "pos[town]" => "Yaoundé",
            "pos[address]" => "",
            "pos[capacity]" => 95000,
        ]];

        yield[[
            "pos[code]" => "STA00",
            "pos[name]" => "Tawaal Oil AKAK",
            "pos[description]" => "Station service",
            "pos[town]" => "Yaoundé",
            "pos[address]" => "BP 10075",
        ]];
    }
}
