<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class UpdateTypeCompanyTest
 * @package App\Tests\Integration
 */
class UpdateTypeCompanyTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulTypeCompanyUpdated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("typecompany.edit", ["id" => 5])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("typecompany.update", ["id" => 5])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 3; $i <= 3; $i++) {
            $crawler = $client->request(
                Request::METHOD_GET,
                $router->generate("typecompany.edit", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_OK);

            $form = $crawler->filter("form")->form([
                "type_company[code]" => "00" . $i,
                "type_company[name]" => "Fournisseur Beta" . $i,
                "type_company[description]" => "Fournisseur et autres alpha" . $i,
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
            $router->generate("typecompany.edit", ["id" => 1])
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
            "type_company[code]" => "",
            "type_company[name]" => "Fournisseur Beta",
            "type_company[description]" => "Fournisseur et autres alpha",
        ]];
        yield[[
            "type_company[code]" => "00",
            "type_company[name]" => "",
            "type_company[description]" => "Fournisseur et autres alpha",
        ]];
        yield[[
            "type_company[code]" => "00",
            "type_company[name]" => "Fournisseur Beta",
            "type_company[description]" => "",
        ]];
    }
}
