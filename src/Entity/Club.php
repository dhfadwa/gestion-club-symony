<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich; // Assurez-vous d'importer cette annotation
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\ClubRepository")
 */
class Club
{
    /**
     *
     * @ORM\Column( type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

   /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Category",inversedBy="clubs")
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
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Membre",mappedBy="membre")
     */
    private $membres;
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Club",mappedBy="club")
     */
    private $evenemnts;
    public function __constructt()
    {
        $this->evenements=new ArrayCollection();
    }
    public function __construct()
    {
        $this->membres=new ArrayCollection();
    } 

    public function getCategory():?Category
    {
        return $this->category;
    }
    public function setCategory(?Category $category):self
    {
        $this->category=$category;
        return $this;
    }
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
    private $email;

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
    private $type;

    public function getId():?int
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


    public function getEmail():?string
    {
        return $this->email;
    }
    public function setEmail(string $email):self
    {
        $this->email=$email;
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

    public function getType():?string
    {
        return $this->type;
    }
    public function setType(string $type):self
    {
        $this->type=$type;
        return $this;
    }



     /**
     * @return Collection|Membre[]
     */
    public function getMembre():Membre
    {
        return $this->membres;
    }
    public function addMembre(Membre $membre):self
    {
        if(!$this->membres->contains($membre)){
            $this->membres[]=$membre;
            $club->setClub($this);
        }
        return $this;
    }
    public function removeMembre(Membre $membre):self
    {
        if($this->membres->contains($membre)){
            $this->membres->removeElement($membre);
            if($membre->getClub()===$this){
                $membre->setClub(null);
            }
        }
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }


     /**
     * @return Collection|Evenemnt[]
     */
    public function getEvenement():Collection
    {
        return $this->getEvenements;
    }
    public function addEvenement(Evenement $evenemnt):self
    {
        if(!$this->evenements->contains($evenemnt)){
            $this->evenements[]=$evenemnt;
            $evenemnt->setClub($this);
        }
        return $this;
    }
    public function removeEvenement(Evenement $club):self
    {
        if($this->evenements->contains($evenemnt)){
            $this->evenements->removeElement($evenemnt);
            if($evenemnt->getClub()===$this){
                $club->setClub(null);
            }
        }
        return $this;
    }
}
