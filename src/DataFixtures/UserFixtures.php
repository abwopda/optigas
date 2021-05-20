<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Employee;
use App\Entity\Pos;
use App\Entity\Product;
use App\Entity\ProductFamily;
use App\Entity\Pump;
use App\Entity\Tank;
use App\Entity\TypeProduct;
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

        $typeproduct = (new TypeProduct())
            ->setCode("01")
            ->setName("Carburant")
            ->setDescription("Produits inflammable Super,Gasoil, Petrole")
            ->setCreateBy($employee)
        ;

        $manager->persist($typeproduct);

        $productfamily = (new ProductFamily($typeproduct))
            ->setCode("CAR")
            ->setName("Carburant")
            ->setDescription("Produits inflammable Super,Gasoil, Petrole")
            ->setCreateBy($employee)
        ;

        $manager->persist($productfamily);

        $product = (new Product($productfamily))
            ->setCode("CAR01")
            ->setName("Super")
            ->setDescription("Produit inflammable")
            ->setCreateBy($employee)
        ;

        $manager->persist($product);

        $product = (new Product($productfamily))
            ->setCode("CAR02")
            ->setName("Gasoil")
            ->setDescription("Produit inflammable")
            ->setCreateBy($employee)
        ;

        $manager->persist($product);

        $product = (new Product($productfamily))
            ->setCode("CAR03")
            ->setName("Petrole")
            ->setDescription("Produit inflammable")
            ->setCreateBy($employee)
        ;

        $manager->persist($product);

        $typeproduct = (new TypeProduct())
            ->setCode("02")
            ->setName("Lubrifiants")
            ->setDescription("Huiles et graisses")
            ->setCreateBy($employee)
        ;

        $manager->persist($typeproduct);

        $productfamily = (new ProductFamily($typeproduct))
            ->setCode("LUB")
            ->setName("Lubrifiant")
            ->setDescription("Huiles")
            ->setCreateBy($employee)
        ;

        $manager->persist($productfamily);

        $product = (new Product($productfamily))
            ->setCode("LUB01")
            ->setName("Huile 40")
            ->setDescription("Huile")
            ->setCreateBy($employee)
        ;

        $manager->persist($product);

        $product = (new Product($productfamily))
            ->setCode("LUB02")
            ->setName("Huile 15W40")
            ->setDescription("Huile")
            ->setCreateBy($employee)
        ;

        $manager->persist($product);

        $product = (new Product($productfamily))
            ->setCode("LUB03")
            ->setName("Huile 20W50")
            ->setDescription("Huile")
            ->setCreateBy($employee)
        ;

        $manager->persist($product);

        $productfamily = (new ProductFamily($typeproduct))
            ->setCode("GRA")
            ->setName("Graisse")
            ->setDescription("Graisses")
            ->setCreateBy($employee)
        ;

        $manager->persist($productfamily);

        $product = (new Product($productfamily))
            ->setCode("GRA01")
            ->setName("Multifack")
            ->setDescription("Graisse")
            ->setCreateBy($employee)
        ;

        $manager->persist($product);

        $typeproduct = (new TypeProduct())
            ->setCode("03")
            ->setName("Divers")
            ->setDescription("Autres produits de maintenance")
            ->setCreateBy($employee)
        ;

        $manager->persist($typeproduct);

        $productfamily = (new ProductFamily($typeproduct))
            ->setCode("FIL")
            ->setName("Filtre")
            ->setDescription("Filtres")
            ->setCreateBy($employee)
        ;

        $manager->persist($productfamily);

        $product = (new Product($productfamily))
            ->setCode("FIL01")
            ->setName("Filtre Mercedes 190")
            ->setDescription("Filtre")
            ->setCreateBy($employee)
        ;

        $manager->persist($product);

        $productfamily = (new ProductFamily($typeproduct))
            ->setCode("DET")
            ->setName("Detergent")
            ->setDescription("Detergents")
            ->setCreateBy($employee)
        ;

        $manager->persist($productfamily);

        $product = (new Product($productfamily))
            ->setCode("DET01")
            ->setName("Lave glace")
            ->setDescription("Divers")
            ->setCreateBy($employee)
        ;

        $manager->persist($product);

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

        $tank = (new Tank($pos))
            ->setCode("CUV0101")
            ->setName("Super")
            ->setDescription("Tawaal Oil AKAK")
            ->setCapacity("30000")
            ->setCreateBy($employee)
        ;

        $manager->persist($tank);

        $pump = (new Pump($tank))
            ->setCode("POM010101")
            ->setName("Super 1")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("3121555")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);

        $pump = (new Pump($tank))
            ->setCode("POM010102")
            ->setName("Super 2")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("66985222")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);

        $pump = (new Pump($tank))
            ->setCode("POM010103")
            ->setName("Super 3")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("46546565")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);

        $pump = (new Pump($tank))
            ->setCode("POM010104")
            ->setName("Super 4")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("6979944")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);

        $pump = (new Pump($tank))
            ->setCode("POM010105")
            ->setName("Super 5")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("466667")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);

        $tank = (new Tank($pos))
            ->setCode("CUV0102")
            ->setName("Gasoil 1")
            ->setDescription("Tawaal Oil AKAK")
            ->setCapacity("30000")
            ->setCreateBy($employee)
        ;

        $manager->persist($tank);

        $pump = (new Pump($tank))
            ->setCode("POM010201")
            ->setName("Gasoil 1")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("255588")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);

        $pump = (new Pump($tank))
            ->setCode("POM010202")
            ->setName("Gasoil 2")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("4569654")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);

        $pump = (new Pump($tank))
            ->setCode("POM010203")
            ->setName("Gasoil 3")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("325644")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);

        $pump = (new Pump($tank))
            ->setCode("POM010204")
            ->setName("Gasoil 4")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("4589322")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);

        $tank = (new Tank($pos))
            ->setCode("CUV0103")
            ->setName("Gasoil 2")
            ->setDescription("Tawaal Oil AKAK")
            ->setCapacity("15000")
            ->setCreateBy($employee)
        ;

        $manager->persist($tank);

        $pump = (new Pump($tank))
            ->setCode("POM010301")
            ->setName("Gasoil 5")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("15479")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);

        $tank = (new Tank($pos))
            ->setCode("CUV0104")
            ->setName("Petrole")
            ->setDescription("Tawaal Oil AKAK")
            ->setCapacity("15000")
            ->setCreateBy($employee)
        ;

        $manager->persist($tank);

        $pump = (new Pump($tank))
            ->setCode("POM010401")
            ->setName("petrole")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("84572")
            ->setCreateBy($employee)
        ;

        $manager->persist($pump);

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

        $tank = (new Tank($pos))
            ->setCode("CUV0201")
            ->setName("Super")
            ->setDescription("Tawaal Oil Sangmelima")
            ->setCapacity("30000")
            ->setCreateBy($employee)
        ;

        $manager->persist($tank);

        $tank = (new Tank($pos))
            ->setCode("CUV0202")
            ->setName("Gasoil")
            ->setDescription("Tawaal Oil Sangmelima")
            ->setCapacity("50000")
            ->setCreateBy($employee)
        ;

        $manager->persist($tank);

        $pos = (new Pos())
            ->setCode("STA03")
            ->setName("Tawaal Oil Ngoya 1")
            ->setDescription("Station service")
            ->setTown("Ngoya")
            ->setAddress("BP 10075")
            ->setCapacity("70000")
            ->setCreateBy($employee)
        ;

        $manager->persist($pos);
        $manager->flush();
    }
}
