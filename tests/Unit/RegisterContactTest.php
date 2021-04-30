<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ContactRepository;
use App\Entity\Contact;
use App\UseCase\RegisterContact;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegisterContactTest
 * @package App\Tests\Unit
 */
class RegisterContactTest extends TestCase
{
    public function testSuccessfulRegistration()
    {
        $userPasswordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $userPasswordEncoder->method("encodePassword")->willReturn("hash_password");

        $useCase = new RegisterContact(new ContactRepository($userPasswordEncoder), $userPasswordEncoder);

        $contact = new Contact();
        $contact->setPlainPassword("Password123!");
        $contact->setEmail("email@email.com");
        $contact->setFirstName("John");
        $contact->setLastName("Doe");
        $contact->setCompanyName("Company");

        $this->assertEquals($contact, $useCase->execute($contact));
    }

    /**
     * @dataProvider provideBadContact
     * @param Contact $contact
     */
    public function testBadContact(Contact $contact)
    {
        $userPasswordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $userPasswordEncoder->method("encodePassword")->willReturn("hash_password");

        $useCase = new RegisterContact(new ContactRepository($userPasswordEncoder), $userPasswordEncoder);

        $this->expectException(lazyAssertionException::class);

        $useCase->execute($contact);
    }

    /**
     * @return \Generator
     */
    public function provideBadContact(): \Generator
    {
        yield[
            (new Contact())
                ->setLastName("Doe")
                ->setEmail("email@email.com")
                ->setPlainPassword("Password123!")
                ->setCompanyName("Company")
        ];

        yield[
            (new Contact())
                ->setFirstName("")
                ->setLastName("Doe")
                ->setEmail("email@email.com")
                ->setPlainPassword("Password123!")
                ->setCompanyName("Company")
        ];

        yield[
            (new Contact())
                ->setFirstName("John")
                ->setEmail("email@email.com")
                ->setPlainPassword("Password123!")
                ->setCompanyName("Company")
        ];

        yield[
            (new Contact())
                ->setFirstName("John")
                ->setLastName("")
                ->setEmail("email@email.com")
                ->setPlainPassword("Password123!")
                ->setCompanyName("Company")
        ];

        yield[
            (new Contact())
                ->setFirstName("John")
                ->setLastName("Doe")
                ->setPlainPassword("Password123!")
                ->setCompanyName("Company")
        ];

        yield[
            (new Contact())
                ->setFirstName("John")
                ->setLastName("Doe")
                ->setEmail("")
                ->setPlainPassword("Password123!")
                ->setCompanyName("Company")
        ];

        yield[
            (new Contact())
                ->setFirstName("John")
                ->setLastName("Doe")
                ->setEmail("fail")
                ->setPlainPassword("Password123!")
                ->setCompanyName("Company")
        ];

        yield[
            (new Contact())
                ->setFirstName("John")
                ->setLastName("Doe")
                ->setEmail("email@email.com")
                ->setCompanyName("Company")
        ];

        yield[
            (new Contact())
                ->setFirstName("John")
                ->setLastName("Doe")
                ->setEmail("email@email.com")
                ->setPlainPassword("")
                ->setCompanyName("Company")
        ];
    }
}
