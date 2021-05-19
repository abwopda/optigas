<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @package App\Entity
 * @ORM\Entity
 */
class Product
{
    /**
     * @var int|null
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @var string|null
     * @ORM\Column(type="string", unique=true)
     */
    private ?string $code = null;

    /**
     * @var string|null
     * @ORM\Column(type="string")
     */
    private ?string $name = null;

    /**
     * @var string|null
     * @ORM\Column(type="string")
     */
    private ?string $description = null;

    /**
     * @var ProductFamily
     * @ORM\ManyToOne(targetEntity="ProductFamily")
     */
    private ProductFamily $productfamily;

    /**
     * @var bool|null
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $active = null;

    /**
     * @var bool|null
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $valid = null;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeInterface $createAt;

    /**
     * @var \DateTimeInterface|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updateAt = null;

    /**
     * @var \DateTimeInterface|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $activateAt = null;

    /**
     * @var \DateTimeInterface|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $validateAt = null;

    /**
     * @var Employee
     * @ORM\ManyToOne(targetEntity="Employee")
     */
    private Employee $createBy;

    /**
     * @var Employee|null
     * @ORM\ManyToOne(targetEntity="Employee")
     */
    private ?Employee $updateBy = null;

    /**
     * @var Employee|null
     * @ORM\ManyToOne(targetEntity="Employee")
     */
    private ?Employee $activateBy = null;

    /**
     * @var Employee|null
     * @ORM\ManyToOne(targetEntity="Employee")
     */
    private ?Employee $validateBy = null;


    /**
     * Product constructor.
     * @param ProductFamily $typeProduct
     */
    public function __construct(ProductFamily $typeProduct)
    {
        $this->createAt = new \DateTimeImmutable();
        $this->productfamily = $typeProduct;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return Product
     */
    public function setCode(?string $code): Product
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Product
     */
    public function setName(?string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Product
     */
    public function setDescription(?string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @param bool|null $active
     * @return Product
     */
    public function setActive(?bool $active): Product
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getValid(): ?bool
    {
        return $this->valid;
    }

    /**
     * @param bool|null $valid
     * @return Product
     */
    public function setValid(?bool $valid): Product
    {
        $this->valid = $valid;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    /**
     * @param \DateTimeInterface|null $updateAt
     * @return Product
     */
    public function setUpdateAt(?\DateTimeInterface $updateAt): Product
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getActivateAt(): ?\DateTimeInterface
    {
        return $this->activateAt;
    }

    /**
     * @param \DateTimeInterface|null $activateAt
     * @return Product
     */
    public function setActivateAt(?\DateTimeInterface $activateAt): Product
    {
        $this->activateAt = $activateAt;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getValidateAt(): ?\DateTimeInterface
    {
        return $this->validateAt;
    }

    /**
     * @param \DateTimeInterface|null $validateAt
     * @return Product
     */
    public function setValidateAt(?\DateTimeInterface $validateAt): Product
    {
        $this->validateAt = $validateAt;
        return $this;
    }

    /**
     * @return Employee
     */
    public function getCreateBy(): Employee
    {
        return $this->createBy;
    }

    /**
     * @param Employee $createBy
     * @return Product
     */
    public function setCreateBy(Employee $createBy): Product
    {
        $this->createBy = $createBy;
        return $this;
    }

    /**
     * @return Employee|null
     */
    public function getUpdateBy(): ?Employee
    {
        return $this->updateBy;
    }

    /**
     * @param Employee|null $updateBy
     * @return Product
     */
    public function setUpdateBy(?Employee $updateBy): Product
    {
        $this->updateBy = $updateBy;
        return $this;
    }

    /**
     * @return Employee|null
     */
    public function getActivateBy(): ?Employee
    {
        return $this->activateBy;
    }

    /**
     * @param Employee|null $activateBy
     * @return Product
     */
    public function setActivateBy(?Employee $activateBy): Product
    {
        $this->activateBy = $activateBy;
        return $this;
    }

    /**
     * @return Employee|null
     */
    public function getValidateBy(): ?Employee
    {
        return $this->validateBy;
    }

    /**
     * @param Employee|null $validateBy
     * @return Product
     */
    public function setValidateBy(?Employee $validateBy): Product
    {
        $this->validateBy = $validateBy;
        return $this;
    }

    /**
     * @return ProductFamily
     */
    public function getProductfamily(): ProductFamily
    {
        return $this->productfamily;
    }

    /**
     * @param ProductFamily $productfamily
     * @return Product
     */
    public function setProductfamily(ProductFamily $productfamily): Product
    {
        $this->productfamily = $productfamily;
        return $this;
    }
}
