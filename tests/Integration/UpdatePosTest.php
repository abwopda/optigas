<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\UpdatePos;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class UpdatePosTest
 * @package App\Tests\Integration
 */
class UpdatePosTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulPosUpdated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("pos.edit", ["id" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "pos[code]" => "STA01",
            "pos[name]" => "Tawaal Oil AKAK Beta",
            "pos[description]" => "Station service Alpha",
            "pos[town]" => "Douala",
            "pos[address]" => "BP 0000",
            "pos[capacity]" => 78,
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
            $router->generate("pos.edit", ["id" => 1])
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
            "pos[code]" => "",
            "pos[name]" => "Tawaal Oil AKAK Beta",
            "pos[description]" => "Station service Alpha",
            "pos[town]" => "Douala",
            "pos[address]" => "BP 0000",
            "pos[capacity]" => 78,
        ]];
        yield[[
            "pos[code]" => "STA01",
            "pos[name]" => "",
            "pos[description]" => "Station service Alpha",
            "pos[town]" => "Douala",
            "pos[address]" => "BP 0000",
            "pos[capacity]" => 78,
        ]];
        yield[[
            "pos[code]" => "STA01",
            "pos[name]" => "Tawaal Oil AKAK Beta",
            "pos[description]" => "",
            "pos[town]" => "Douala",
            "pos[address]" => "BP 0000",
            "pos[capacity]" => 78,
        ]];
        yield[[
            "pos[code]" => "STA01",
            "pos[name]" => "Tawaal Oil AKAK Beta",
            "pos[description]" => "Station service Alpha",
            "pos[town]" => "",
            "pos[address]" => "BP 0000",
            "pos[capacity]" => 78,
        ]];
        yield[[
            "pos[code]" => "STA01",
            "pos[name]" => "Tawaal Oil AKAK Beta",
            "pos[description]" => "Station service Alpha",
            "pos[town]" => "Douala",
            "pos[address]" => "",
            "pos[capacity]" => 78,
        ]];
    }
}
