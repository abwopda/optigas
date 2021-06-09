<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\StoreRepository;
use App\Entity\Store;
use App\UseCase\UseStore;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class UpdateStoreTest
 * @package App\Tests\Integration
 */
class UpdateStoreTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulStoreUpdated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("store.edit", ["id" => 5])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("store.update", ["id" => 5])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        for ($i = 3; $i <= 3; $i++) {
            $crawler = $client->request(
                Request::METHOD_GET,
                $router->generate("store.edit", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_OK);

            $form = $crawler->filter("form")->form([
                "store[code]" => "STA00" . $i,
                "store[name]" => "SCDP Beta" . $i,
                "store[description]" => "Depot SCDP Beta" . $i,
                "store[town]" => "town" . $i,
                "store[address]" => "BP 0000" . $i,
                "store[products]" => ["1","2","3"],
                "store[poss]" => ["1","3"],
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
            $router->generate("store.edit", ["id" => 1])
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
            "store[code]" => "",
            "store[name]" => "SCDP Beta",
            "store[description]" => "Depot SCDP Beta",
            "store[town]" => "Douala",
            "store[address]" => "BP 0000",
        ]];
        yield[[
            "store[code]" => "STA01",
            "store[name]" => "",
            "store[description]" => "Depot SCDP Beta",
            "store[town]" => "Douala",
            "store[address]" => "BP 0000",
        ]];
        yield[[
            "store[code]" => "STA01",
            "store[name]" => "SCDP Beta",
            "store[description]" => "",
            "store[town]" => "Douala",
            "store[address]" => "BP 0000",
        ]];
        yield[[
            "store[code]" => "STA01",
            "store[name]" => "SCDP Beta",
            "store[description]" => "Depot SCDP Beta",
            "store[town]" => "",
            "store[address]" => "BP 0000",
        ]];
    }
}
