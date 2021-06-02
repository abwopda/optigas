<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\Product;
use App\UseCase\UseProduct;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class UpdateProductTest
 * @package App\Tests\Integration
 */
class UpdateProductTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulProductUpdated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("product.edit", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("product.update", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 3; $i <= 3; $i++) {
            $crawler = $client->request(
                Request::METHOD_GET,
                $router->generate("product.edit", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_OK);

            $form = $crawler->filter("form")->form([
                "product[code]" => "C00" . $i,
                "product[name]" => "Produit alpha" . $i,
                "product[description]" => "Famille carburant" . $i,
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
            $router->generate("product.edit", ["id" => 1])
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
            "product[code]" => "",
            "product[name]" => "Produit alpha",
            "product[description]" => "Famille carburant",
        ]];
        yield[[
            "product[code]" => "C00",
            "product[name]" => "",
            "product[description]" => "Famille carburant",
        ]];
        yield[[
            "product[code]" => "C00",
            "product[name]" => "Produit alpha",
            "product[description]" => "",
        ]];
    }
}
