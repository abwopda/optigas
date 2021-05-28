<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Config
 * @package App\Entity
 * @ORM\Entity
 */
class Config
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
     * @ORM\Column(name="the_key", type="string", length=255)
     */
    private ?string $theKey = null;

    /**
     * @var string|null
     * @ORM\Column(name="the_value", type="text")
     */
    private ?string $theValue = null;

    /**
     * Config constructor.
     * @param $theKey
     * @param $theValue
     */
    public function __construct($theKey = null, $theValue = null)
    {
        $this->theKey = $theKey;
        $this->theValue = $theValue;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $theKey
     * @return Config
     */
    public function setTheKey(?string $theKey): Config
    {
        $this->theKey = $theKey;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTheKey(): ?string
    {
        return $this->theKey;
    }

    /**
     * @param string|null $theValue
     * @return Config
     */
    public function setTheValue(?string $theValue): Config
    {
        $this->theValue = $theValue;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTheValue(): ?string
    {
        return $this->theValue;
    }
}
