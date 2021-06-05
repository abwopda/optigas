<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\CompanyRepository;
use App\Entity\TypeCompany;
use App\Entity\Company;
use App\UseCase\UseCompany;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CreateCompanyTest
 * @package App\Tests\Integration
 */
class CreateCompanyTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulCompanyCreated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("company.create")
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "company[code]" => "00",
            "company[name]" => "Compagnie 00",
            "company[description]" => "Compagnie des zozos",
            "company[families]" => ["1","5"]
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
            $router->generate("company.new")
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
            "company[name]" => "Compagnie 00",
            "company[description]" => "Compagnie des zozos",
        ]];

        yield[[
            "company[code]" => "",
            "company[name]" => "Compagnie 00",
            "company[description]" => "Compagnie des zozos",
        ]];

        yield[[
            "company[code]" => "00",
            "company[description]" => "Compagnie des zozos",
        ]];

        yield[[
            "company[code]" => "00",
            "company[name]" => "",
            "company[description]" => "Compagnie des zozos",
        ]];

        yield[[
            "company[code]" => "00",
            "company[name]" => "Compagnie 00",
        ]];

        yield[[
            "company[code]" => "00",
            "company[name]" => "Compagnie 00",
            "company[description]" => "",
        ]];
    }
}
