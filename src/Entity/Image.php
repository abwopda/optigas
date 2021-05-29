<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="image")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Image
{
    /**
     * @var int|null
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
    * @var file $file
    * @Assert\File(
    *      maxSize = "2M",
    *      mimeTypes = {"image/jpeg", "image/pjpeg", "image/png", "image/x-png", "image/gif"},
    *      mimeTypesMessage = "Format d'image est inconnu",
    *      uploadIniSizeErrorMessage = "Fichier est trop volumineux",
    *      uploadFormSizeErrorMessage = "Fichier  plus grand que celui autorisé par le champ de saisie du fichier HTML",
    *      uploadErrorMessage = "Fichier ne peut être transféré pour une raison inconnue",
    *      maxSizeMessage = "Fichier est trop volumineux"
    * )
    */
    private ?file $file = null;

    // propriété utilisé temporairement pour la suppression
    private $filenameForRemove;

     /************ Le constructeur ************/

    public function __construct()
    {
        $this->alt = 'image';
        $this->path = 'anonymous.png';
    }

    /************ Les setters et getters ************/

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file): image
    {
        $this->file = $file;
        return $this;
    }


    /**
     * Get path
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
     /**
     * Set path
     *
     * @param image $path
     * @return profil
     */
    public function setPath(image $path)
    {
        $this->path = $path;
        return $this;
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath(): ?string
    {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir(): string
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir(): string
    {
        return 'uploads/img';
    }

    public function upload(): bool
    {
        // var_dump(pathinfo($this->file, PATHINFO_EXTENSION));die();
        if (null === $this->file) {
            return false;
        } else {
            $this->path = sha1(uniqid(mt_rand(), true)) . '.' . $this->file->guessExtension();
        }

        $this->file->move($this->getUploadRootDir(), $this->path);
        unset($this->file);
        return true;
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->filenameForRemove = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $default1 = $this->getUploadRootDir() . '/anonymous.png';
        $default2 = $this->getUploadRootDir() . '/unknown.png';
        $default3 = $this->getUploadRootDir() . '/jpeg.png';
        if ($this->filenameForRemove) {
            if ($this->filenameForRemove != $default1) {
                if ($this->filenameForRemove != $default2) {
                    unlink($this->filenameForRemove);
                }
            }
        }
    }
    public function manualRemove($filenameForRemove)
    {
        if (null === $this->file) {
            return;
        }
        $default1 = $this->getUploadRootDir() . '/anonymous.png';
        $default2 = $this->getUploadRootDir() . '/unknown.png';
        $default3 = $this->getUploadRootDir() . '/jpeg.png';

        if ($filenameForRemove != $default1 and $filenameForRemove != $default2 and $filenameForRemove != $default3) {
            if (!preg_match("#http://#", $filenameForRemove)) {
                unlink($filenameForRemove);
            }
        }
    }
}
