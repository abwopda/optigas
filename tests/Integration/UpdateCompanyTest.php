<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\CompanyRepository;
use App\Entity\Company;
use App\UseCase\UseCompany;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class UpdateCompanyTest
 * @package App\Tests\Integration
 */
class UpdateCompanyTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulCompanyUpdated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("company.edit", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("company.update", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 6; $i <= 6; $i++) {
            $crawler = $client->request(
                Request::METHOD_GET,
                $router->generate("company.edit", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_OK);

            $form = $crawler->filter("form")->form([
                "company[code]" => "C00" . $i,
                "company[name]" => "Compagnie alpha" . $i,
                "company[description]" => "Famille carburant" . $i,
                "company[families]" => ["2","3"],
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
            $router->generate("company.edit", ["id" => 1])
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
            "company[code]" => "",
            "company[name]" => "Compagnie alpha",
            "company[description]" => "Famille carburant",
        ]];
        yield[[
            "company[code]" => "C00",
            "company[name]" => "",
            "company[description]" => "Famille carburant",
        ]];
        yield[[
            "company[code]" => "C00",
            "company[name]" => "Compagnie alpha",
            "company[description]" => "",
        ]];
    }
}
