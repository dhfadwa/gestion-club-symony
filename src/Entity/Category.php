<?php

namespace App\Entity;
use Doctrine\Common\Collections\Collection; // Importez la classe Collection

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
    private $titre;

   /**
     *
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Club",mappedBy="category")
     */
    private $clubs;
    public function __construct()
    {
        $this->clubs=new ArrayCollection();
    }
    public function getId():?int
    {
        return $this->id;
    }
    public function getTitre():?string
    {
        return $this->titre;
    }
    public function setTitre(string $titre):self
    {
        $this->titre=$titre;
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

    /**
     * @return Collection|Club[]
     */
    public function getClub():Collection
    {
        return $this->clubs;
    }
    public function addClub(Club $club):self
    {
        if(!$this->clubs->contains($club)){
            $this->clubs[]=$club;
            $club->setCategory($this);
        }
        return $this;
    }
    public function removeClub(Club $club):self
    {
        if($this->clubs->contains($club)){
            $this->clubs->removeElement($club);
            if($club->getCategory()===$this){
                $club->setCategory(null);
            }
        }
        return $this;
    }
}
