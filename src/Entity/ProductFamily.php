<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductFamily
 * @package App\Entity
 * @ORM\Entity
 */
class ProductFamily
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
     * @var TypeProduct
     * @ORM\ManyToOne(targetEntity="TypeProduct")
     */
    private TypeProduct $typeproduct;

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
     * ProductFamily constructor.
     * @param TypeProduct $typeProduct
     */
    public function __construct(TypeProduct $typeProduct)
    {
        $this->createAt = new \DateTimeImmutable();
        $this->typeproduct = $typeProduct;
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
     * @return ProductFamily
     */
    public function setCode(?string $code): ProductFamily
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
     * @return ProductFamily
     */
    public function setName(?string $name): ProductFamily
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
     * @return ProductFamily
     */
    public function setDescription(?string $description): ProductFamily
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
     * @return ProductFamily
     */
    public function setActive(?bool $active): ProductFamily
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
     * @return ProductFamily
     */
    public function setValid(?bool $valid): ProductFamily
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
     * @return ProductFamily
     */
    public function setUpdateAt(?\DateTimeInterface $updateAt): ProductFamily
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
     * @return ProductFamily
     */
    public function setActivateAt(?\DateTimeInterface $activateAt): ProductFamily
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
     * @return ProductFamily
     */
    public function setValidateAt(?\DateTimeInterface $validateAt): ProductFamily
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
     * @return ProductFamily
     */
    public function setCreateBy(Employee $createBy): ProductFamily
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
     * @return ProductFamily
     */
    public function setUpdateBy(?Employee $updateBy): ProductFamily
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
     * @return ProductFamily
     */
    public function setActivateBy(?Employee $activateBy): ProductFamily
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
     * @return ProductFamily
     */
    public function setValidateBy(?Employee $validateBy): ProductFamily
    {
        $this->validateBy = $validateBy;
        return $this;
    }

    /**
     * @return TypeProduct
     */
    public function getTypeproduct(): TypeProduct
    {
        return $this->typeproduct;
    }

    /**
     * @param TypeProduct $typeproduct
     * @return ProductFamily
     */
    public function setTypeproduct(TypeProduct $typeproduct): ProductFamily
    {
        $this->typeproduct = $typeproduct;
        return $this;
    }
}
