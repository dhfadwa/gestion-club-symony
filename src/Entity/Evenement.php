<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich; // Assurez-vous d'importer cette annotation
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     *
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $nom;
     /**
     *
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $description;

     /**
     *
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $contexte;

       /**
     *
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $lieu;

       /**
     *
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $date;

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
    private $postulaire;
    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Club",inversedBy="evenements")
    *@ORM\JoinColumn(nullable=false)
    */
    private $club;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom():?string
    {
        return $this->nom;
    }
    public function setNom(string $nom):self
    {
        $this->nom=$nom;
        return $this;
    }

    public function getDescription():?string
    {
        return $this->description;
    }
    public function setDescription(string $description):self
    {
        $this->description=$description;
        return $this;
    }

    public function getContexte():?string
    {
        return $this->contexte;
    }
    public function setContexte(string $contexte):self
    {
        $this->contexte=$contexte;
        return $this;
    }
    public function getLieu():?string
    {
        return $this->lieu;
    }
    public function setLieu(string $lieu):self
    {
        $this->lieu=$lieu;
        return $this;
    }

    public function getDate():?string
    {
        return $this->date;
    }
    public function setDate(string $date):self
    {
        $this->date=$date;
        return $this;
    }
    public function getImageFile():?File
    {
        return $this->imageFile;
    }
    public function setImageFile(?File $imageFile):self
    {
        $this->imageFile=$imageFile;
        return $this;
    }

    public function getPostulaire(): ?string
    {
        return $this->postulaire;
    }

    public function setPostulaire(?string $postulaire): self
    {
        $this->postulaire = $postulaire;
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
}
