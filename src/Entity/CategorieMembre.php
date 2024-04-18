<?php

namespace App\Entity;
use Doctrine\Common\Collections\Collection; // Importez la classe Collection
use Doctrine\Common\Collections\ArrayCollection; // Importez la classe ArrayCollection

use App\Repository\CategorieMembreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieMembreRepository::class)
 */
class CategorieMembre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Membre", mappedBy="category")
     */
    private $membres;

    public function __construct()
    {
        $this->membres=new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
     /**
     * @ORM\Column(type="string",length=255)
     */
    private $titre;
     /**
     * @ORM\Column(type="string",length=300)
     */
    private $description;

    public function getTitre(): ?string
    {
        return $this->titre;
    }
    public function setTitre(string $titre):self{
        $this->titre=$titre;
        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(string $description):self{
        $this->description=$description;
        return $this;
    }


      /**
     * @return Collection|Membre[]
     */
    public function getMembre():Collection
    {
        return $this->membres;
    }
    public function addMembre(Membre $membre):self{
        if (!$this->membres->contains($membre))
        {
            $this->membres[]=$membre;
            $membres->getCategorymembre($this);
        }
        return $this;
    }

    public function removeMembre(Membre $membre):self{
        if ($this->membres->contains($membre))
        {
            $this->membres->removeElement($membre);
            if($membre->getCategorymembre()===$this)
            {
                $membre->setCategorymembre(null);
            }
        }
        return $this;
    }
}
