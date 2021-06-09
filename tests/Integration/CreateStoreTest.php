<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CreateStoreTest
 * @package App\Tests\Integration
 */
class CreateStoreTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulStoreCreated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("store.new")
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "store[code]" => "STO00",
            "store[name]" => "SCDP XX",
            "store[description]" => "Depot produits pétroliers",
            "store[town]" => "Yaoundé",
            "store[address]" => "BR AAAA",
            "store[products]" => ["1","2"],
            "store[poss]" => ["2","3"],
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
            $router->generate("store.create")
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
            "store[name]" => "SCDP XX",
            "store[description]" => "Depot produits pétroliers",
            "store[town]" => "Yaoundé",
            "store[address]" => "BR AAAA",
        ]];

        yield[[
            "store[code]" => "",
            "store[name]" => "SCDP XX",
            "store[description]" => "Depot produits pétroliers",
            "store[town]" => "Yaoundé",
            "store[address]" => "BR AAAA",
        ]];

        yield[[
            "store[code]" => "STO00",
            "store[description]" => "Depot produits pétroliers",
            "store[town]" => "Yaoundé",
            "store[address]" => "BR AAAA",
        ]];

        yield[[
            "store[code]" => "STO00",
            "store[name]" => "",
            "store[description]" => "Depot produits pétroliers",
            "store[town]" => "Yaoundé",
            "store[address]" => "BR AAAA",
        ]];

        yield[[
            "store[code]" => "STO00",
            "store[name]" => "SCDP XX",
            "store[town]" => "Yaoundé",
            "store[address]" => "BR AAAA",
        ]];

        yield[[
            "store[code]" => "STO00",
            "store[name]" => "SCDP XX",
            "store[description]" => "",
            "store[town]" => "Yaoundé",
            "store[address]" => "BR AAAA",
        ]];

        yield[[
            "store[code]" => "STO00",
            "store[name]" => "SCDP XX",
            "store[description]" => "Depot produits pétroliers",
            "store[address]" => "BR AAAA",
        ]];

        yield[[
            "store[code]" => "STO00",
            "store[name]" => "SCDP XX",
            "store[description]" => "Depot produits pétroliers",
            "store[town]" => "",
            "store[address]" => "BR AAAA",
        ]];

        yield[[
            "store[code]" => "STO00",
            "store[name]" => "SCDP XX",
            "store[description]" => "Depot produits pétroliers",
            "store[town]" => "Yaoundé",
        ]];

        yield[[
            "store[code]" => "STO00",
            "store[name]" => "SCDP XX",
            "store[description]" => "Depot produits pétroliers",
            "store[town]" => "Yaoundé",
            "store[address]" => "",
        ]];
    }
}
