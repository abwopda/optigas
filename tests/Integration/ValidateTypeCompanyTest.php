<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Retypecompanyitory\TypeCompanyRetypecompanyitory;
use App\Entity\TypeCompany;
use App\UseCase\UseTypeCompany;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ValidateTypeCompanyTest
 * @package App\Tests\Integration
 */
class ValidateTypeCompanyTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulTypeCompanyValidated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_POST,
            $router->generate("typecompany.validate.one", ["id" => 10])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $crawler = $client->request(
            Request::METHOD_POST,
            $router->generate("typecompany.invalidate.one", ["id" => 10])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 3; $i <= 3; $i++) {
            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("typecompany.validate.one", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);


            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("typecompany.invalidate.one", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        }
    }
}
