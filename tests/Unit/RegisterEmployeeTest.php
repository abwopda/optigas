<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\EmployeeRepository;
use App\Entity\Employee;
use App\UseCase\RegisterEmployee;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegisterEmployeeTest
 * @package App\Tests\Unit
 */
class RegisterEmployeeTest extends TestCase
{
    public function testSuccessfulRegistration()
    {
        $userPasswordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $userPasswordEncoder->method("encodePassword")->willReturn("hash_password");

        $useCase = new RegisterEmployee(new EmployeeRepository($userPasswordEncoder), $userPasswordEncoder);

        $employee = new Employee();
        $employee->setPlainPassword("Password123!");
        $employee->setEmail("email@email.com");
        $employee->setFirstName("John");
        $employee->setLastName("Doe");

        $this->assertEquals($employee, $useCase->execute($employee));
    }

    /**
     * @dataProvider provideBadEmployee
     * @param Employee $employee
     */
    public function testBadEmployee(Employee $employee)
    {
        $userPasswordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $userPasswordEncoder->method("encodePassword")->willReturn("hash_password");

        $useCase = new RegisterEmployee(new EmployeeRepository($userPasswordEncoder), $userPasswordEncoder);

        $this->expectException(lazyAssertionException::class);

        $useCase->execute($employee);
    }

    /**
     * @return \Generator
     */
    public function provideBadEmployee(): \Generator
    {
        yield[
            (new Employee())
                ->setLastName("Doe")
                ->setEmail("email@email.com")
                ->setPlainPassword("Password123!")
        ];

        yield[
            (new Employee())
                ->setFirstName("")
                ->setLastName("Doe")
                ->setEmail("email@email.com")
                ->setPlainPassword("Password123!")
        ];

        yield[
            (new Employee())
                ->setFirstName("John")
                ->setEmail("email@email.com")
                ->setPlainPassword("Password123!")
        ];

        yield[
            (new Employee())
                ->setFirstName("John")
                ->setLastName("")
                ->setEmail("email@email.com")
                ->setPlainPassword("Password123!")
        ];

        yield[
            (new Employee())
                ->setFirstName("John")
                ->setLastName("Doe")
                ->setPlainPassword("Password123!")
        ];

        yield[
            (new Employee())
                ->setFirstName("John")
                ->setLastName("Doe")
                ->setEmail("")
                ->setPlainPassword("Password123!")
        ];

        yield[
            (new Employee())
                ->setFirstName("John")
                ->setLastName("Doe")
                ->setEmail("fail")
                ->setPlainPassword("Password123!")
        ];

        yield[
            (new Employee())
                ->setFirstName("John")
                ->setLastName("Doe")
                ->setEmail("email@email.com")
        ];

        yield[
            (new Employee())
                ->setFirstName("John")
                ->setLastName("Doe")
                ->setEmail("email@email.com")
                ->setPlainPassword("")
        ];

        yield[
            (new Employee())
                ->setFirstName("John")
                ->setLastName("Doe")
                ->setEmail("email@email.com")
                ->setPlainPassword("fail")
        ];
    }
}
