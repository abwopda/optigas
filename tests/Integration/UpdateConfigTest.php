<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\ConfigRepository;
use App\Entity\Config;
use App\UseCase\UpdateConfig;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class UpdateConfigTest
 * @package App\Tests\Integration
 */
class UpdateConfigTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulConfigUpdated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("config.edit", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);


        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("config.edit", ["id" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter("form")->form([
            "config[the_key]" => "KEY",
            "config[the_value]" => "VALUE",
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
            $router->generate("config.edit", ["id" => 3])
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
            "config[the_key]" => "KEY",
            "config[the_value]" => "",
        ]];
        yield[[
            "config[the_key]" => "",
            "config[the_value]" => "VALUE",
        ]];
    }
}
