<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Contact;
use App\Entity\Employee;
use App\Gateway\UserGateway;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserRepository
 * @package App\Adapter\InMemory\Repository
 */
class UserRepository implements UserGateway
{
    /**
     * @var User[]
     */
    public array $users = [];

    /**
     * UserRepository constructor.
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $employee = (new Employee())
            ->setFirstName("John")
            ->setLastName("Doe")
            ->setEmail("employee@email.com")
        ;
        $employee->setPassword($userPasswordEncoder->encodePassword($employee, "Password123!"));

        $contact = (new Contact())
            ->setFirstName("Jane")
            ->setLastName("Doe")
            ->setCompanyName("Company")
            ->setEmail("contact@email.com")
        ;
        $contact->setPassword($userPasswordEncoder->encodePassword($contact, "Password123!"));

        $this->users = [
            "employee@email.com" => $employee,
            "contact@email.com"  => $contact
        ];
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(string $email): ?UserInterface
    {
        if (!isset($this->users[$email])) {
            throw new UsernameNotFoundException();
        }

        return $this->users[$email];
    }
}
