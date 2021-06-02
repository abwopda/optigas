<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\ProductFamilyRepository;
use App\Entity\TypeProduct;
use App\Entity\ProductFamily;
use App\UseCase\UseProductFamily;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CreateProductFamilyTest
 * @package App\Tests\Integration
 */
class CreateProductFamilyTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulProductFamilyCreated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("productfamily.create", ["typeproduct" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "product_family[code]" => "00",
            "product_family[name]" => "Famille 00",
            "product_family[description]" => "Famille des zozos",
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
            $router->generate("productfamily.new", ["typeproduct" => 1])
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
            "product_family[name]" => "Famille 00",
            "product_family[description]" => "Famille des zozos",
        ]];

        yield[[
            "product_family[code]" => "",
            "product_family[name]" => "Famille 00",
            "product_family[description]" => "Famille des zozos",
        ]];

        yield[[
            "product_family[code]" => "00",
            "product_family[description]" => "Famille des zozos",
        ]];

        yield[[
            "product_family[code]" => "00",
            "product_family[name]" => "",
            "product_family[description]" => "Famille des zozos",
        ]];

        yield[[
            "product_family[code]" => "00",
            "product_family[name]" => "Famille 00",
        ]];

        yield[[
            "product_family[code]" => "00",
            "product_family[name]" => "Famille 00",
            "product_family[description]" => "",
        ]];
    }
}
