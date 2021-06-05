<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Company
 * @package App\Entity
 * @ORM\Entity
 */
class Company
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
     * @ORM\ManyToMany(targetEntity="CompanyFamily", mappedBy="companies")
     */
    private ?Collection $families;

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
     * Company constructor.
     */
    public function __construct()
    {
        $this->createAt = new \DateTimeImmutable();
        $this->families = new ArrayCollection();
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
     * @return Company
     */
    public function setCode(?string $code): Company
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
     * @return Company
     */
    public function setName(?string $name): Company
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
     * @return Company
     */
    public function setDescription(?string $description): Company
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
     * @return Company
     */
    public function setActive(?bool $active): Company
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
     * @return Company
     */
    public function setValid(?bool $valid): Company
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
     * @return Company
     */
    public function setUpdateAt(?\DateTimeInterface $updateAt): Company
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
     * @return Company
     */
    public function setActivateAt(?\DateTimeInterface $activateAt): Company
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
     * @return Company
     */
    public function setValidateAt(?\DateTimeInterface $validateAt): Company
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
     * @return Company
     */
    public function setCreateBy(Employee $createBy): Company
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
     * @return Company
     */
    public function setUpdateBy(?Employee $updateBy): Company
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
     * @return Company
     */
    public function setActivateBy(?Employee $activateBy): Company
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
     * @return Company
     */
    public function setValidateBy(?Employee $validateBy): Company
    {
        $this->validateBy = $validateBy;
        return $this;
    }

    /**
     * @return Collection|CompanyFamily[]
     */
    public function getFamilies(): Collection
    {
        return $this->families;
    }

    public function addFamily(CompanyFamily $family): self
    {
        if (!$this->families->contains($family)) {
            $this->families[] = $family;
            $family->addCompany($this);
        }

        return $this;
    }

    public function removeFamily(CompanyFamily $family): self
    {
        if ($this->families->contains($family)) {
            $this->families->removeElement($family);
            $family->removeCompany($this);
        }

        return $this;
    }
}
