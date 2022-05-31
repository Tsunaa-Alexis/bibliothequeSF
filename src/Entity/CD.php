<?php

namespace App\Entity;

use App\Repository\CDRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CDRepository::class)]
class CD extends Documents
{

    #[ORM\Column(type: 'integer')]
    private $nbPistes;

    public function getNbPistes(): ?int
    {
        return $this->nbPistes;
    }

    public function setNbPistes(int $nbPistes): self
    {
        $this->nbPistes = $nbPistes;

        return $this;
    }
}
