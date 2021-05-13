<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Employee;
use App\Entity\Pos;
use App\Entity\Pump;
use App\Entity\Tank;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $userPasswordEncoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        $employee = (new Employee())
            ->setFirstName("John")
            ->setLastName("Doe")
            ->setEmail("employee@email.com")
        ;
        $employee->setPassword($this->userPasswordEncoder->encodePassword($employee, "Password123!"));

        $manager->persist($employee);

        $contact = (new Contact())
            ->setFirstName("Jane")
            ->setLastName("Doe")
            ->setCompanyName("Company")
            ->setEmail("contact@email.com")
        ;
        $contact->setPassword($this->userPasswordEncoder->encodePassword($contact, "Password123!"));

        $manager->persist($contact);
        $manager->flush();

        $pos = (new Pos())
            ->setCode("STA01")
            ->setName("Tawaal Oil AKAK")
            ->setDescription("Station service")
            ->setTown("Yaoundé")
            ->setAddress("BP 10075")
            ->setCapacity("95000")
            ->setCreateBy($employee)
        ;

        $manager->persist($pos);
        $manager->flush();

        $tank = (new Tank($pos))
            ->setCode("CUV0101")
            ->setName("Super")
            ->setDescription("Tawaal Oil AKAK")
            ->setCapacity("30000")
            ->setCreateBy($employee)
        ;

        $manager->persist($tank);
        $manager->flush();

        $pump = (new Pump($tank))
            ->setCode("POM010101")
            ->setName("Super 1")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("3121555")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);
        $manager->flush();

        $pump = (new Pump($tank))
            ->setCode("POM010102")
            ->setName("Super 2")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("66985222")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);
        $manager->flush();

        $tank = (new Tank($pos))
            ->setCode("CUV0102")
            ->setName("Gasoil 1")
            ->setDescription("Tawaal Oil AKAK")
            ->setCapacity("30000")
            ->setCreateBy($employee)
        ;

        $manager->persist($tank);
        $manager->flush();

        $pump = (new Pump($tank))
            ->setCode("POM010201")
            ->setName("Gasoil 1")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("255588")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);
        $manager->flush();

        $tank = (new Tank($pos))
            ->setCode("CUV0103")
            ->setName("Gasoil 2")
            ->setDescription("Tawaal Oil AKAK")
            ->setCapacity("15000")
            ->setCreateBy($employee)
        ;

        $manager->persist($tank);
        $manager->flush();

        $pos = (new Pos())
            ->setCode("STA02")
            ->setName("Tawaal Oil Sangmelima")
            ->setDescription("Station service")
            ->setTown("Sangmelima")
            ->setAddress("BP 10075")
            ->setCapacity("80000")
            ->setCreateBy($employee)
        ;

        $manager->persist($pos);
        $manager->flush();

        $tank = (new Tank($pos))
            ->setCode("CUV0201")
            ->setName("Super")
            ->setDescription("Tawaal Oil Sangmelima")
            ->setCapacity("30000")
            ->setCreateBy($employee)
        ;

        $manager->persist($tank);
        $manager->flush();

        $tank = (new Tank($pos))
            ->setCode("CUV0202")
            ->setName("Gasoil")
            ->setDescription("Tawaal Oil Sangmelima")
            ->setCapacity("50000")
            ->setCreateBy($employee)
        ;

        $manager->persist($tank);
        $manager->flush();
    }
}
