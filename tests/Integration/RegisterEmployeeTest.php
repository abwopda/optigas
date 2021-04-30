<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\EmployeeRepository;
use App\Entity\Employee;
use App\UseCase\RegisterEmployee;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RegisterEmployeeTest
 * @package App\Tests\Integration
 */
class RegisterEmployeeTest extends WebTestCase
{
    public function testSuccessfulRegistration()
    {
        $client = static::createClient();

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("register_employee")
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "registration[firstName]" => "John",
            "registration[lastName]" => "Doe",
            "registration[email]" => "email@email.com",
            "registration[plainPassword]" => "Password123!"
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
        $client = static::createClient();

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("register_employee")
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
            "registration[firstName]" => "",
            "registration[lastName]" => "Doe",
            "registration[email]" => "email@email.com",
            "registration[plainPassword]" => "Password123!"
        ]];

        yield[[
            "registration[lastName]" => "Doe",
            "registration[email]" => "email@email.com",
            "registration[plainPassword]" => "Password123!"
        ]];

        yield[[
            "registration[firstName]" => "John",
            "registration[lastName]" => "",
            "registration[email]" => "email@email.com",
            "registration[plainPassword]" => "Password123!"
        ]];

        yield[[
            "registration[firstName]" => "John",
            "registration[email]" => "email@email.com",
            "registration[plainPassword]" => "Password123!"
        ]];

        yield[[
            "registration[firstName]" => "John",
            "registration[lastName]" => "Doe",
            "registration[email]" => "",
            "registration[plainPassword]" => "Password123!"
        ]];

        yield[[
            "registration[firstName]" => "John",
            "registration[lastName]" => "Doe",
            "registration[plainPassword]" => "Password123!"
        ]];

        yield[[
            "registration[firstName]" => "John",
            "registration[lastName]" => "Doe",
            "registration[email]" => "fail",
            "registration[plainPassword]" => "Password123!"
        ]];

        yield[[
            "registration[firstName]" => "John",
            "registration[lastName]" => "Doe",
            "registration[email]" => "email@email.com",
            "registration[plainPassword]" => ""
        ]];

        yield[[
            "registration[firstName]" => "John",
            "registration[lastName]" => "Doe",
            "registration[email]" => "email@email.com",
        ]];

        yield[[
            "registration[firstName]" => "John",
            "registration[lastName]" => "Doe",
            "registration[email]" => "email@email.com",
            "registration[plainPassword]" => "fail"
        ]];
    }
}
