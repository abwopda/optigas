<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\CompanyFamily;
use App\Entity\Contact;
use App\Entity\Employee;
use App\Entity\Pos;
use App\Entity\Product;
use App\Entity\ProductFamily;
use App\Entity\Pump;
use App\Entity\Store;
use App\Entity\Tank;
use App\Entity\TypeCompany;
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
    private $employee;
    private $typeproduct = [];
    private $productfamily = [];
    private $product = [];
    private $pos = [];
    private $tank = [];
    private $pump = [];
    private $typecompany = [];
    private $companyfamily = [];
    private $company = [];

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    private function loadTypeProduct(ObjectManager $manager)
    {
        $this->typeproduct[1] = (new TypeProduct())
            ->setCode("01")
            ->setName("Carburant")
            ->setDescription("Produits inflammable Super,Gasoil, Petrole")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->typeproduct[1]);

        $this->typeproduct[2] = (new TypeProduct())
            ->setCode("02")
            ->setName("Lubrifiants")
            ->setDescription("Huiles et graisses")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->typeproduct[2]);

        $this->typeproduct[3] = (new TypeProduct())
            ->setCode("03")
            ->setName("Divers")
            ->setDescription("Autres produits de maintenance")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->typeproduct[3]);
    }

    private function loadProductFamily(ObjectManager $manager)
    {
        $this->productfamily[1] = (new ProductFamily($this->typeproduct[1]))
            ->setCode("CAR")
            ->setName("Carburant")
            ->setDescription("Produits inflammable Super,Gasoil, Petrole")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->productfamily[1]);

        $this->productfamily[2] = (new ProductFamily($this->typeproduct[2]))
            ->setCode("LUB")
            ->setName("Lubrifiant")
            ->setDescription("Huiles")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->productfamily[2]);

        $this->productfamily[3] = (new ProductFamily($this->typeproduct[2]))
            ->setCode("GRA")
            ->setName("Graisse")
            ->setDescription("Graisses")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->productfamily[3]);

        $this->productfamily[4] = (new ProductFamily($this->typeproduct[3]))
            ->setCode("FIL")
            ->setName("Filtre")
            ->setDescription("Filtres")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->productfamily[4]);

        $this->productfamily[5] = (new ProductFamily($this->typeproduct[3]))
            ->setCode("DET")
            ->setName("Detergent")
            ->setDescription("Detergents")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->productfamily[5]);
    }

    private function loadProduct($manager)
    {
        $this->product[1] = (new Product($this->productfamily[1]))
            ->setCode("CAR01")
            ->setName("Super")
            ->setDescription("Produit inflammable")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->product[1]);

        $this->product[2] = (new Product($this->productfamily[1]))
            ->setCode("CAR02")
            ->setName("Gasoil")
            ->setDescription("Produit inflammable")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->product[2]);

        $this->product[3] = (new Product($this->productfamily[1]))
            ->setCode("CAR03")
            ->setName("Petrole")
            ->setDescription("Produit inflammable")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->product[3]);

        $this->product[4] = (new Product($this->productfamily[2]))
            ->setCode("LUB01")
            ->setName("Huile 40")
            ->setDescription("Huile")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->product[4]);

        $this->product[5] = (new Product($this->productfamily[2]))
            ->setCode("LUB02")
            ->setName("Huile 15W40")
            ->setDescription("Huile")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->product[5]);

        $this->product[6] = (new Product($this->productfamily[2]))
            ->setCode("LUB03")
            ->setName("Huile 20W50")
            ->setDescription("Huile")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->product[6]);

        $this->product[7] = (new Product($this->productfamily[3]))
            ->setCode("GRA01")
            ->setName("Multifack")
            ->setDescription("Graisse")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->product[7]);

        $this->product[8] = (new Product($this->productfamily[4]))
            ->setCode("FIL01")
            ->setName("Filtre Mercedes 190")
            ->setDescription("Filtre")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->product[8]);

        $this->product[9] = (new Product($this->productfamily[5]))
            ->setCode("DET01")
            ->setName("Lave glace")
            ->setDescription("Divers")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->product[9]);
    }

    private function loadPos($manager)
    {
        $this->pos[1] = (new Pos())
            ->setCode("STA01")
            ->setName("Tawaal Oil AKAK")
            ->setDescription("Station service")
            ->setTown("Yaoundé")
            ->setAddress("BP 10075")
            ->setCapacity("95000")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pos[1]);

        $this->pos[2] = (new Pos())
            ->setCode("STA02")
            ->setName("Tawaal Oil Sangmelima")
            ->setDescription("Station service")
            ->setTown("Sangmelima")
            ->setAddress("BP 10075")
            ->setCapacity("80000")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pos[2]);

        $this->pos[3] = (new Pos())
            ->setCode("STA03")
            ->setName("Tawaal Oil Ngoya 1")
            ->setDescription("Station service")
            ->setTown("Ngoya")
            ->setAddress("BP 10075")
            ->setCapacity("70000")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pos[3]);
    }

    private function loadTank($manager)
    {
        $this->tank[1] = (new Tank($this->pos[1]))
            ->setCode("CUV0101")
            ->setName("Super")
            ->setDescription("Tawaal Oil AKAK")
            ->setCapacity("30000")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->tank[1]);

        $this->tank[2] = (new Tank($this->pos[1]))
            ->setCode("CUV0102")
            ->setName("Gasoil 1")
            ->setDescription("Tawaal Oil AKAK")
            ->setCapacity("30000")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->tank[2]);

        $this->tank[3] = (new Tank($this->pos[1]))
            ->setCode("CUV0103")
            ->setName("Gasoil 2")
            ->setDescription("Tawaal Oil AKAK")
            ->setCapacity("15000")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->tank[3]);

        $this->tank[4] = (new Tank($this->pos[1]))
            ->setCode("CUV0104")
            ->setName("Petrole")
            ->setDescription("Tawaal Oil AKAK")
            ->setCapacity("15000")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->tank[4]);

        $this->tank[6] = (new Tank($this->pos[2]))
            ->setCode("CUV0201")
            ->setName("Super")
            ->setDescription("Tawaal Oil Sangmelima")
            ->setCapacity("30000")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->tank[6]);

        $this->tank[7] = (new Tank($this->pos[2]))
            ->setCode("CUV0202")
            ->setName("Gasoil")
            ->setDescription("Tawaal Oil Sangmelima")
            ->setCapacity("50000")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->tank[7]);
    }

    private function loadPump($manager)
    {
        $this->pump[1] = (new Pump($this->tank[1]))
            ->setCode("POM010101")
            ->setName("Super 1")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("3121555")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pump[1]);

        $this->pump[2] = (new Pump($this->tank[1]))
            ->setCode("POM010102")
            ->setName("Super 2")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("66985222")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pump[2]);

        $this->pump[3] = (new Pump($this->tank[1]))
            ->setCode("POM010103")
            ->setName("Super 3")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("46546565")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pump[3]);

        $this->pump[4] = (new Pump($this->tank[1]))
            ->setCode("POM010104")
            ->setName("Super 4")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("6979944")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pump[4]);

        $this->pump[5] = (new Pump($this->tank[1]))
            ->setCode("POM010105")
            ->setName("Super 5")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("466667")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pump[5]);

        $this->pump[6] = (new Pump($this->tank[2]))
            ->setCode("POM010201")
            ->setName("Gasoil 1")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("255588")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pump[6]);

        $this->pump[7] = (new Pump($this->tank[2]))
            ->setCode("POM010202")
            ->setName("Gasoil 2")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("4569654")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pump[7]);

        $this->pump[8] = (new Pump($this->tank[2]))
            ->setCode("POM010203")
            ->setName("Gasoil 3")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("325644")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pump[8]);

        $this->pump[9] = (new Pump($this->tank[2]))
            ->setCode("POM010204")
            ->setName("Gasoil 4")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("4589322")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pump[9]);

        $this->pump[10] = (new Pump($this->tank[3]))
            ->setCode("POM010301")
            ->setName("Gasoil 5")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("15479")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pump[10]);

        $this->pump[11] = (new Pump($this->tank[4]))
            ->setCode("POM010401")
            ->setName("petrole")
            ->setDescription("Tawaal Oil AKAK")
            ->setCounter("84572")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->pump[11]);
    }

    private function loadTypeCompany($manager)
    {
        $this->typecompany[1] = (new TypeCompany())
            ->setCode("01")
            ->setName("Fournisseur")
            ->setDescription("Fournisseurs")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->typecompany[1]);

        $this->typecompany[2] = (new TypeCompany())
            ->setCode("02")
            ->setName("Clients")
            ->setDescription("Clients")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->typecompany[2]);

        $this->typecompany[3] = (new TypeCompany())
            ->setCode("03")
            ->setName("Sous-traitants")
            ->setDescription("Autres")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->typecompany[3]);
    }

    private function loadCompanyFamily($manager)
    {
        $this->companyfamily[1] = (new CompanyFamily($this->typecompany[1]))
            ->setCode("CAR01")
            ->setName("Fournisseur Carburant")
            ->setDescription("Fournisseurs de carburant")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->companyfamily[1]);

        $this->companyfamily[2] = (new CompanyFamily($this->typecompany[1]))
            ->setCode("LUB01")
            ->setName("Fournisseur de lubrifiants")
            ->setDescription("Fournisseurs de lubes")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->companyfamily[2]);

        $this->companyfamily[3] = (new CompanyFamily($this->typecompany[1]))
            ->setCode("DIV01")
            ->setName("Autre Fournisseur")
            ->setDescription("Fournisseurs XXXX")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->companyfamily[3]);

        $this->companyfamily[4] = (new CompanyFamily($this->typecompany[2]))
            ->setCode("CAR02")
            ->setName("Clients Carburant")
            ->setDescription("Clients de carburant")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->companyfamily[4]);

        $this->companyfamily[5] = (new CompanyFamily($this->typecompany[2]))
            ->setCode("LUB02")
            ->setName("Client Lubes")
            ->setDescription("Clients de lubrifiants")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->companyfamily[5]);

        $this->companyfamily[6] = (new CompanyFamily($this->typecompany[2]))
            ->setCode("DIV02")
            ->setName("Autre Client")
            ->setDescription("Clients YYYY")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->companyfamily[6]);

        $this->companyfamily[7] = (new CompanyFamily($this->typecompany[3]))
            ->setCode("DIV03")
            ->setName("Sous-traitant")
            ->setDescription("Autres partenaires")
            ->setCreateBy($this->employee)
        ;

        $manager->persist($this->companyfamily[7]);
    }

    private function loadCompany($manager)
    {
        $this->company[1] = (new Company())
            ->setCode("FOU01")
            ->setName("SONARA")
            ->setDescription("Societe Nationale de Rafinage")
            ->setCreateBy($this->employee)
            ->addFamily($this->companyfamily[1])
        ;

        $manager->persist($this->company[1]);

        $this->company[2] = (new Company())
            ->setCode("FOU02")
            ->setName("Green Oil Sarl")
            ->setDescription("Societe de distribution des produits pétroliers")
            ->setCreateBy($this->employee)
            ->addFamily($this->companyfamily[1])
            ->addFamily($this->companyfamily[3])
        ;

        $manager->persist($this->company[2]);

        $this->company[3] = (new Company())
            ->setCode("FOU03")
            ->setName("Confex Oil")
            ->setDescription("Societe de distribution des produits pétroliers")
            ->setCreateBy($this->employee)
            ->addFamily($this->companyfamily[1])
            ->addFamily($this->companyfamily[3])
        ;

        $manager->persist($this->company[3]);

        $this->company[4] = (new Company())
            ->setCode("CLI001")
            ->setName("SOTRACOM")
            ->setDescription("Societe de transport")
            ->setCreateBy($this->employee)
            ->setActive(true)
            ->setActivateBy($this->employee)
            ->setActivateAt(new \DateTimeImmutable())
            ->addFamily($this->companyfamily[3])
        ;

        $manager->persist($this->company[4]);

        $this->company[5] = (new Company())
            ->setCode("CLI002")
            ->setName("STE NDZOMOU & BWAJ")
            ->setDescription("Societe de transport")
            ->setCreateBy($this->employee)
            ->setActive(true)
            ->setActivateBy($this->employee)
            ->setActivateAt(new \DateTimeImmutable())
            ->addFamily($this->companyfamily[1])
            ->addFamily($this->companyfamily[3])
            ->addFamily($this->companyfamily[4])
            ->addFamily($this->companyfamily[7])
        ;

        $manager->persist($this->company[5]);

        $this->company[6] = (new Company())
            ->setCode("CLI003")
            ->setName("Carriere Chinois")
            ->setDescription("Societe de Carriere")
            ->setCreateBy($this->employee)
            ->setActive(true)
            ->setActivateBy($this->employee)
            ->setActivateAt(new \DateTimeImmutable())
            ->addFamily($this->companyfamily[3])
            ->addFamily($this->companyfamily[4])
        ;

        $manager->persist($this->company[6]);

        $this->company[7] = (new Company())
            ->setCode("FOU04")
            ->setName("ELOI SERVICES")
            ->setDescription("Societe de MOUAMOUA")
            ->setCreateBy($this->employee)
            ->setValid(true)
            ->setValidateBy($this->employee)
            ->setValidateAt(new \DateTimeImmutable())
            ->addFamily($this->companyfamily[1])
            ->addFamily($this->companyfamily[3])
        ;

        $manager->persist($this->company[7]);

        $this->company[8] = (new Company())
            ->setCode("DIV01")
            ->setName("BANKOL SERVICES")
            ->setDescription("Entreprise de maintenance")
            ->setCreateBy($this->employee)
            ->setActive(true)
            ->setActivateBy($this->employee)
            ->setActivateAt(new \DateTimeImmutable())
            ->setValid(true)
            ->setValidateBy($this->employee)
            ->setValidateAt(new \DateTimeImmutable())
            ->addFamily($this->companyfamily[7])
        ;

        $manager->persist($this->company[8]);
    }

    private function loadStore($manager)
    {
        $this->store[1] = (new Store())
            ->setCode("01")
            ->setName("SONARA")
            ->setDescription("PCCC Limbe")
            ->setTown("Limbe")
            ->setAddress("BP JGKHYJJG")
            ->setCreateBy($this->employee)
            ->setActive(true)
            ->setActivateBy($this->employee)
            ->setActivateAt(new \DateTimeImmutable())
            ->addProduct($this->product[1])
            ->addProduct($this->product[2])
            ->addProduct($this->product[3])
        ;

        $manager->persist($this->store[1]);

        $this->store[2] = (new Store())
            ->setCode("02")
            ->setName("SCDP Douala")
            ->setDescription("Depot SCDP de Mboppi")
            ->setTown("Douala")
            ->setAddress("BP AAAA")
            ->setCreateBy($this->employee)
            ->setActive(true)
            ->setActivateBy($this->employee)
            ->setActivateAt(new \DateTimeImmutable())
            ->addProduct($this->product[1])
            ->addProduct($this->product[2])
            ->addProduct($this->product[3])
        ;

        $manager->persist($this->store[2]);

        $this->store[3] = (new Store())
            ->setCode("03")
            ->setName("SCDP Yaounde")
            ->setDescription("Depot SCDP de Nsam")
            ->setTown("Yaounde")
            ->setAddress("BP BBBB")
            ->setCreateBy($this->employee)
            ->setActive(true)
            ->setActivateBy($this->employee)
            ->setActivateAt(new \DateTimeImmutable())
            ->addProduct($this->product[1])
            ->addProduct($this->product[2])
            ->addProduct($this->product[3])
            ->addPos($this->pos[1])
            ->addPos($this->pos[2])
            ->addPos($this->pos[3])
        ;

        $manager->persist($this->store[3]);
    }

    public function load(ObjectManager $manager)
    {
        $this->employee = (new Employee())
            ->setFirstName("John")
            ->setLastName("Doe")
            ->setEmail("employee@email.com")
        ;
        $this->employee->setPassword($this->userPasswordEncoder->encodePassword($this->employee, "Password123!"));

        $manager->persist($this->employee);

        $contact = (new Contact())
            ->setFirstName("Jane")
            ->setLastName("Doe")
            ->setCompanyName("Company")
            ->setEmail("contact@email.com")
        ;
        $contact->setPassword($this->userPasswordEncoder->encodePassword($contact, "Password123!"));

        $manager->persist($contact);

        $this->loadTypeProduct($manager);

        $this->loadProductFamily($manager);

        $this->loadProduct($manager);

        $this->loadPos($manager);

        $this->loadTank($manager);

        $this->loadPump($manager);

        $this->loadTypeCompany($manager);

        $this->loadCompanyFamily($manager);

        $this->loadCompany($manager);

        $this->loadStore($manager);

        $manager->flush();
    }
}
