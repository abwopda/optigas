<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CreatePos
 * @package App\Entity
 * @ORM\Entity
 */
class Pos
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
     * @var string|null
     * @ORM\Column(type="string")
     */
    private ?string $town = null;

    /**
     * @var string|null
     * @ORM\Column(type="string")
     */
    private ?string $address = null;

    /**
     * @var int|null
     * @ORM\Column(type="integer")
     */
    private ?int $capacity = null;

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
     * CreatePos constructor.
     */
    public function __construct()
    {
        $this->createAt = new \DateTimeImmutable();
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
     * @return Pos
     */
    public function setCode(?string $code): Pos
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
     * @return Pos
     */
    public function setName(?string $name): Pos
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
     * @return Pos
     */
    public function setDescription(?string $description): Pos
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTown(): ?string
    {
        return $this->town;
    }

    /**
     * @param string|null $town
     * @return Pos
     */
    public function setTown(?string $town): Pos
    {
        $this->town = $town;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return Pos
     */
    public function setAddress(?string $address): Pos
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    /**
     * @param int|null $capacity
     * @return Pos
     */
    public function setCapacity(?int $capacity): Pos
    {
        $this->capacity = $capacity;
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
     * @return Pos
     */
    public function setActive(?bool $active): Pos
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
     * @return Pos
     */
    public function setValid(?bool $valid): Pos
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
     * @return Pos
     */
    public function setUpdateAt(?\DateTimeInterface $updateAt): Pos
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
     * @return Pos
     */
    public function setActivateAt(?\DateTimeInterface $activateAt): Pos
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
     * @return Pos
     */
    public function setValidateAt(?\DateTimeInterface $validateAt): Pos
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
     * @return Pos
     */
    public function setCreateBy(Employee $createBy): Pos
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
     * @return Pos
     */
    public function setUpdateBy(?Employee $updateBy): Pos
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
     * @return Pos
     */
    public function setActivateBy(?Employee $activateBy): Pos
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
     * @return Pos
     */
    public function setValidateBy(?Employee $validateBy): Pos
    {
        $this->validateBy = $validateBy;
        return $this;
    }
}
