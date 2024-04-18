<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

class ClubSearch
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Club")
     */
    private $club;

    public function getClub(): ?Club
    {
        return $this->club;
    }
    public function setClub(?Club $club):self
    {
        $this->club=$club;
        return $this;
    }
}