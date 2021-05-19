<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class UpdateTypeProductTest
 * @package App\Tests\Integration
 */
class UpdateTypeProductTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulTypeProductUpdated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("typeproduct.edit", ["id" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "type_product[code]" => "00",
            "type_product[name]" => "Confiserie Beta",
            "type_product[description]" => "Confitures et autres alpha",
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
            $router->generate("typeproduct.edit", ["id" => 1])
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
            "type_product[code]" => "",
            "type_product[name]" => "Confiserie Beta",
            "type_product[description]" => "Confitures et autres alpha",
        ]];
        yield[[
            "type_product[code]" => "00",
            "type_product[name]" => "",
            "type_product[description]" => "Confitures et autres alpha",
        ]];
        yield[[
            "type_product[code]" => "00",
            "type_product[name]" => "Confiserie Beta",
            "type_product[description]" => "",
        ]];
    }
}
