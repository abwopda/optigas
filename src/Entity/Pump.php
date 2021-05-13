<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tank
 * @package App\Entity
 * @ORM\Entity
 */
class Pump
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
     * @var int|null
     * @ORM\Column(type="integer")
     */
    private ?int $counter = null;

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
     * @var Tank
     * @ORM\ManyToOne(targetEntity="Tank")
     */
    private Tank $tank;

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
     * Pump constructor.
     * @param Tank $tank
     */
    public function __construct(Tank $tank)
    {
        $this->createAt = new \DateTimeImmutable();
        $this->tank = $tank;
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
     * @return Pump
     */
    public function setCode(?string $code): Pump
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
     * @return Pump
     */
    public function setName(?string $name): Pump
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
     * @return Pump
     */
    public function setDescription(?string $description): Pump
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCounter(): ?int
    {
        return $this->counter;
    }

    /**
     * @param int|null $counter
     * @return Pump
     */
    public function setCounter(?int $counter): Pump
    {
        $this->counter = $counter;
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
     * @return Pump
     */
    public function setActive(?bool $active): Pump
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
     * @return Pump
     */
    public function setValid(?bool $valid): Pump
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
     * @return Pump
     */
    public function setUpdateAt(?\DateTimeInterface $updateAt): Pump
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
     * @return Pump
     */
    public function setActivateAt(?\DateTimeInterface $activateAt): Pump
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
     * @return Pump
     */
    public function setValidateAt(?\DateTimeInterface $validateAt): Pump
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
     * @return Pump
     */
    public function setCreateBy(Employee $createBy): Pump
    {
        $this->createBy = $createBy;
        return $this;
    }

    /**
     * @return Tank
     */
    public function getTank(): Tank
    {
        return $this->tank;
    }

    /**
     * @param Tank $tank
     * @return Pump
     */
    public function setTank(Tank $tank): Pump
    {
        $this->tank = $tank;
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
     * @return Pump
     */
    public function setUpdateBy(?Employee $updateBy): Pump
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
     * @return Pump
     */
    public function setActivateBy(?Employee $activateBy): Pump
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
     * @return Pump
     */
    public function setValidateBy(?Employee $validateBy): Pump
    {
        $this->validateBy = $validateBy;
        return $this;
    }
}
