<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

class CategorySearchM
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieMembre")
     */
    private $category;

    public function getCategory(): ?CategorieMembre
    {
        return $this->category;
    }
    public function setCategory(?CategorieMembre $category):self
    {
        $this->category=$category;
        return $this;
    }
}