<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\CompanyFamilyRepository;
use App\Entity\TypeCompany;
use App\Entity\CompanyFamily;
use App\UseCase\UseCompanyFamily;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CreateCompanyFamilyTest
 * @package App\Tests\Integration
 */
class CreateCompanyFamilyTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulCompanyFamilyCreated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("companyfamily.create", ["typecompany" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "company_family[code]" => "00",
            "company_family[name]" => "Famille 00",
            "company_family[description]" => "Famille des zozos",
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
            $router->generate("companyfamily.new", ["typecompany" => 1])
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
            "company_family[name]" => "Famille 00",
            "company_family[description]" => "Famille des zozos",
        ]];

        yield[[
            "company_family[code]" => "",
            "company_family[name]" => "Famille 00",
            "company_family[description]" => "Famille des zozos",
        ]];

        yield[[
            "company_family[code]" => "00",
            "company_family[description]" => "Famille des zozos",
        ]];

        yield[[
            "company_family[code]" => "00",
            "company_family[name]" => "",
            "company_family[description]" => "Famille des zozos",
        ]];

        yield[[
            "company_family[code]" => "00",
            "company_family[name]" => "Famille 00",
        ]];

        yield[[
            "company_family[code]" => "00",
            "company_family[name]" => "Famille 00",
            "company_family[description]" => "",
        ]];
    }
}
