<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich; // Assurez-vous d'importer cette annotation

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\MembreRepository")
 *  @Vich\Uploadable
 */
class Membre
{
     /**
     *
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;
      /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

      /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $email;

      /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $niveau;

      /**
     *
     * @ORM\Column(type="integer", length=255)
     */
    private $telephone;

     /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Club",inversedBy="clubs")
    *@ORM\JoinColumn(nullable=false)
    */
    private $club;
/**
    * @ORM\ManyToOne(targetEntity="App\Entity\CategorieMembre",inversedBy="membres")
    *@ORM\JoinColumn(nullable=false)
    */
    private $category;

   /**
     * @Vich\UploadableField(mapping="membre_images", fileNameProperty="image")
     * @Assert\File(
     *     maxSize="2M",
     *     mimeTypes={"image/jpeg", "image/png"}
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;
    public function getImageFile():?File
    {
        return $this->imageFile;
    }
    public function setImageFile(?File $imageFile):self
    {
        $this->imageFile=$imageFile;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }
    public function getCategory():?CategorieMembre
    {
        return $this->category;
    }
    public function setCategory(?CategorieMembre $category):self
    {
        $this->category=$category;
        return $this;
    }

  


    public function getClub():?Club
    {
        return $this->club;
    }
    public function setClub(?Club $club):self
    {
        $this->club=$club;
        return $this;
    }
    public function getId():?int
    {
        return $this->id;
    }
    public function getNom():?string
    {
        return $this->nom;
    }
    public function setNom(?string $nom):self
    {
        $this->nom=$nom;
        return $this;
    }


    public function getEmail():?string
    {
        return $this->email;
    }
    public function setEmail(?string $email):self
    {
        $this->email=$email;
        return $this;
    }


    public function getNiveau():?string
    {
        return $this->niveau;
    }
    public function setNiveau(?string $niveau):self
    {
        $this->niveau=$niveau;
        return $this;
    }


    public function getTelephone():?int
    {
        return $this->telephone;
    }
    public function setTelephone(?int $telephone):self
    {
        $this->telephone=$telephone;
        return $this;
    }


}
