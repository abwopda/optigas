<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CreateTypeCompanyTest
 * @package App\Tests\Integration
 */
class CreateTypeCompanyTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulTypeCompanyCreated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("typecompany.new")
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "type_company[code]" => "00",
            "type_company[name]" => "Fournisseur",
            "type_company[description]" => "Fournisseur et autres",
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
            $router->generate("typecompany.create")
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
            "type_company[name]" => "Fournisseur",
            "type_company[description]" => "Fournisseur et autres",
        ]];

        yield[[
            "type_company[code]" => "",
            "type_company[name]" => "Fournisseur",
            "type_company[description]" => "Fournisseur et autres",
        ]];

        yield[[
            "type_company[code]" => "00",
            "type_company[description]" => "Fournisseur et autres",
        ]];

        yield[[
            "type_company[code]" => "00",
            "type_company[name]" => "",
            "type_company[description]" => "Fournisseur et autres",
        ]];

        yield[[
            "type_company[code]" => "00",
            "type_company[name]" => "Fournisseur",
        ]];

        yield[[
            "type_company[code]" => "00",
            "type_company[name]" => "Fournisseur",
            "type_company[description]" => "",
        ]];
    }
}
