<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class UpdateCompanyFamilyTest
 * @package App\Tests\Integration
 */
class UpdateCompanyFamilyTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulCompanyFamilyUpdated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("companyfamily.edit", ["id" => 10])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("companyfamily.update", ["id" => 10])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 7; $i <= 7; $i++) {
            $crawler = $client->request(
                Request::METHOD_GET,
                $router->generate("companyfamily.edit", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_OK);

            $form = $crawler->filter("form")->form([
                "company_family[code]" => "C00" . $i,
                "company_family[name]" => "Carburant alpha" . $i,
                "company_family[description]" => "Famille carburant" . $i
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
            $router->generate("companyfamily.edit", ["id" => 1])
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
            "company_family[code]" => "",
            "company_family[name]" => "Carburant alpha",
            "company_family[description]" => "Famille carburant",
        ]];
        yield[[
            "company_family[code]" => "C00",
            "company_family[name]" => "",
            "company_family[description]" => "Famille carburant",
        ]];
        yield[[
            "company_family[code]" => "C00",
            "company_family[name]" => "Carburant alpha",
            "company_family[description]" => "",
        ]];
    }
}
