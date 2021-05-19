<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\TypeProduct;
use App\Entity\Product;
use App\UseCase\CreateProduct;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CreateProductTest
 * @package App\Tests\Integration
 */
class CreateProductTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulProductCreated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("product.create", ["productfamily" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "product[code]" => "00",
            "product[name]" => "Produit 00",
            "product[description]" => "Produit des zozos",
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
            $router->generate("product.new", ["productfamily" => 1])
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
            "product[name]" => "Produit 00",
            "product[description]" => "Produit des zozos",
        ]];

        yield[[
            "product[code]" => "",
            "product[name]" => "Produit 00",
            "product[description]" => "Produit des zozos",
        ]];

        yield[[
            "product[code]" => "00",
            "product[description]" => "Produit des zozos",
        ]];

        yield[[
            "product[code]" => "00",
            "product[name]" => "",
            "product[description]" => "Produit des zozos",
        ]];

        yield[[
            "product[code]" => "00",
            "product[name]" => "Produit 00",
        ]];

        yield[[
            "product[code]" => "00",
            "product[name]" => "Produit 00",
            "product[description]" => "",
        ]];
    }
}
