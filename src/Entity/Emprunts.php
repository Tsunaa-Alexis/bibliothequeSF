<?php

namespace App\Entity;

use App\Repository\EmpruntsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpruntsRepository::class)]
class Emprunts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $dateEmprunt;

    #[ORM\Column(type: 'integer')]
    private $dateRetour;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'emprunts')]
    private $idUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmprunt(): ?int
    {
        return $this->dateEmprunt;
    }

    public function setDateEmprunt(int $dateEmprunt): self
    {
        $this->dateEmprunt = $dateEmprunt;

        return $this;
    }

    public function getDateRetour(): ?int
    {
        return $this->dateRetour;
    }

    public function setDateRetour(int $dateRetour): self
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

}
